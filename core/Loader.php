<?php
/**
 * Created by PhpStorm.
 * User: Edgar
 * Date: 2/25/2019
 * Time: 8:57 AM
 */

namespace rnadvanceemailingwc\core;



use rnadvanceemailingwc\ajax\EmailBuilderAjax;
use rnadvanceemailingwc\ajax\EmailList;
use rnadvanceemailingwc\core\db\core\DBManager;
use rnadvanceemailingwc\core\db\core\EmailRepository;
use rnadvanceemailingwc\DTO\ConditionBaseOptionsDTO;
use rnadvanceemailingwc\DTO\EmailBuilderOptionsDTO;
use rnadvanceemailingwc\Fields\Core\OrderRetriever;
use rnadvanceemailingwc\Managers\ConditionManager\ConditionManager;
use rnadvanceemailingwc\Managers\TriggerManager\TriggerManager;
use rnadvanceemailingwc\pages\AdvanceEmailList;
use rnadvanceemailingwc\pages\EmailBuilder;
use rnadvanceemailingwc\pr\PRLoader;
use rnadvanceemailingwc\TwigManager\Renderers\EmailRenderer;
use rnadvanceemailingwc\TwigManager\TwigManager;
use rnadvanceemailingwc\Utilities\Sanitizer;

class Loader extends PluginBase
{

    public $PRLoader=null;
    /** @var TwigManager */
    private $Twig;

    /** @var HTMLSanitizer */
    public $HTMLSanitizer;
    public $EMAIL_TABLE;
    public $SCHEDULE_TABLE;
    public $EMAIL_TRIGGER_TABLE;
    public $LINKS;

    public static $Instance;
    public $WCEmailTemplateIds=[];

    public function __construct($filePath,$prefix,$dbVersion,$fileVersion,$config)
    {
        self::$Instance = $this;
        $dbManager = new DBManager();
        /* add_action (
             'wp_after_insert_post',
            array($this,'MaybeSendEmail'),
             10,
             4
         );*/
        $this->EMAIL_TABLE = $dbManager->GetPrefix() . $prefix . '_emails';
        $this->EMAIL_TRIGGER_TABLE = $dbManager->GetPrefix() . $prefix . '_emails_trigger';
        $this->SCHEDULE_TABLE = $dbManager->GetPrefix() . $prefix . '_schedule_email';
        parent::__construct($filePath, $prefix, $dbVersion, $fileVersion);
        new EmailList($this);
        new EmailBuilderAjax($this);
        TriggerManager::Instance()->InitializeHooks();
        $me = $this;

        $this->WCEmailTemplateIds=[
            'new_order',
            'cancelled_order',
            'failed_order',
            'customer_on_hold_order',
            'customer_processing_order',
            'customer_completed_order',
            'customer_refunded_order',
            'customer_invoice',
            'customer_note',
            'reset_password',
            'new_account'
        ];

        if ($this->IsPR())
            new PRLoader($this);

        add_filter('woocommerce_order_actions', array($this, 'GetOrderActions'), 20, 2);
        $matches = [];
        /** To not query the database to get a list of email ids, the plugin parse the wc_order_action and only add the needed hook */
        if (isset($_POST['wc_order_action']) && preg_match('/^aefwc_send_email_(\d+)$/i', $_POST['wc_order_action'], $matches))
        {
            if (count($matches) != 2)
                return;

            $emailId = intval($matches[1]);

            add_filter('woocommerce_order_action_aefwc_send_email_' . $emailId, function ($order) use ($emailId) {
                RNADEM()->SendEmail($emailId, $order, __('Sending "[email_name]" email manually', 'rnadvanceemailingwc'), true);
            }, 10, 2);
        }

        add_filter("bulk_actions-woocommerce_page_wc-orders", array($this, 'AddBulkActions'), 100);
        add_filter("bulk_actions-edit-shop_order", array($this, 'AddBulkActions'), 100);
        add_filter('wc_get_template',array($this,'MaybeOverwriteTemplate'),10,5);

        foreach($this->WCEmailTemplateIds as $templateId)
        {
            add_filter( 'woocommerce_settings_api_form_fields_' . $templateId,array($this,'GetFormFields'),10,1);
        }


        foreach(array_merge(['customer_invoice_paid'],$this->WCEmailTemplateIds) as $templateId)
        {
            add_filter('woocommerce_email_subject_'.$templateId,array($this,'MaybeOverwriteSubject'),10,3);
        }
    }



    public function MaybeOverwriteTemplate($template,$templateName,$args,$templatePath,$defaultPath)
    {
        $advancedEmailId=Sanitizer::GetStringValueFromPath($args,['email','settings','advanced_email']);

        if($advancedEmailId!='')
        {
            $emailRepository=new EmailRepository($this);
            if($emailRepository->EmailExist($advancedEmailId))
            {
                return $this->DIR.'EmailTemplatesOverwrite/EmailContentOverwrite.php';
            }
        }

        return $template;

    }
    public function MaybeOverwriteSubject($subject,$order,$email=null)
    {

        if($email==null)
            return $subject;
        $advancedEmailId=Sanitizer::GetStringValueFromPath($email,['settings','advanced_email']);

        if($advancedEmailId!='')
        {
            $emailRepository=new EmailRepository($this);
            if($emailRepository->EmailExist($advancedEmailId))
            {
                $renderer=RNADEM()->GetEmailRenderedByTemplateId(72,$order);
                if($renderer!=null)
                {
                    $subject=$renderer->GetSubject();
                }
            }
        }


        return $subject;

    }

    public function GetFormFields($formFields)
    {
        $list=RNADEM()->GetEmailList();
        $emails=[
            ''=>__('None (don\'t overwrite template','rnadvanceemailingwc')
        ];

        foreach($list as $currentItem)
        {
            $emails[$currentItem->Id]=$currentItem->Name;
        }

        $formFields['advanced_email'] = array(
            'title'       => __( 'Overwrite with advanced email', 'rnadvanceemailingwc' ),
            'type'        => 'select',
            'description' => __( 'If you overwrite the email, ids content and subject will be replaced by the template that you select.', 'rnadvanceemailingwc' ),
            'default'     => '',
            'class'       => 'email_type wc-enhanced-select',
            'options'     =>$emails,
            'desc_tip'    => true
        );
        return $formFields;
    }

    public function AddBulkActions($actions){
        $emailRepository=new EmailRepository($this);
        $emails=$emailRepository->GetEmailsIdAndName();
        $suffix='';
        if(!$this->IsPR())
            $suffix=' '.__('(Full version only)','rnadvanceemailingwc');


        foreach($emails as $email)
        {
            $actions['aefwc_send_email_'.$email->Id]=__('Send Email: ',"rnadvanceemailingwc").$email->Name.$suffix;
        }

        return $actions;
    }

    public function GetOrderActions($actions,$orders=null)
    {

        $repository=new EmailRepository($this);
        $emails=$repository->GetEmailsIdAndName();

        foreach($emails as $email)
        {
            $actions['aefwc_send_email_'.$email->Id]=__('Send Email: ',"rnadvanceemailingwc").$email->Name;
        }
        return $actions;

    }


    public function CreateHooks()
    {
        add_action('admin_menu',array($this,'CreateMenu'));
    }

    public function CreateMenu(){
        add_submenu_page('woocommerce','Advanced Emailing','Advanced Emailing','manage_woocommerce','rnadvanceemailing',array($this,'EmailList'));
    }

    public function EmailList(){
        if(isset($_GET['emailid']))
            $renderer=new EmailBuilder($this);
        else
            $renderer=new AdvanceEmailList($this);
        $renderer->Render();
    }

    public function IsPR(){

        return \file_exists($this->DIR.'pr');
    }



    public function CheckIfPDFAdmin(){
        if(!current_user_can('manage_options'))
        {
            die('Forbidden');
        }
    }


    /**
     * @return TwigManager
     */
    public function GetTwigManager($paths=[]){

        if($this->Twig==null)
        {
            $this->Twig=new TwigManager($this,$paths);
        }
        return $this->Twig;
    }

    public function OnCreateTable()
    {
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');


        $sql="CREATE TABLE ".$this->EMAIL_TABLE." (
        id int AUTO_INCREMENT,    
        name VARCHAR(100) not null,
        email_header_options MEDIUMTEXT NOT NULL,
        content_options  MEDIUMTEXT,
        custom_fields MEDIUMTEXT,
        PRIMARY KEY  (id)
        ) COLLATE utf8_general_ci;";
        dbDelta($sql);

        $sql="CREATE TABLE ".$this->EMAIL_TRIGGER_TABLE." (
        id int AUTO_INCREMENT,
        email_id int,
        type VARCHAR(100),
        options MEDIUMTEXT,
        PRIMARY KEY  (id)
        ) COLLATE utf8_general_ci;";
        dbDelta($sql);


        $sql="CREATE TABLE ".$this->SCHEDULE_TABLE." (
        id bigint AUTO_INCREMENT,
        email_id int,
        order_id int,
        creation_date datetime,
        schedule_date datetime,
        PRIMARY KEY  (id),
        KEY schedule_id(email_id,order_id)
        ) COLLATE utf8_general_ci;";
        dbDelta($sql);


    }




    public function GetLoader(){
        return $this;
    }

}