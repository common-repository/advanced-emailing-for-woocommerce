<?php

namespace rnadvanceemailingwc\TwigManager\Renderers;

use rnadvanceemailingwc\core\Loader;
use rnadvanceemailingwc\DTO\EmailAddressDTO;
use rnadvanceemailingwc\DTO\EmailBuilderOptionsDTO;
use rnadvanceemailingwc\DTO\SectionOptionsDTO;
use rnadvanceemailingwc\Fields\Core\OrderRetriever;
use rnadvanceemailingwc\Managers\FileManager;
use rnadvanceemailingwc\pr\Fields\CustomField;
use rnadvanceemailingwc\TwigManager\Renderers\Core\ISectionContainer;
use rnadvanceemailingwc\TwigManager\Renderers\Core\RendererBase;
use rnadvanceemailingwc\TwigManager\Renderers\Core\SectionManager;
use rnadvanceemailingwc\TwigManager\SimpleTextRenderer\SimpleTextRenderer;


class EmailRenderer extends RendererBase implements ISectionContainer
{
    /** @var Loader */
    public $Loader;
    /** @var SectionManager  */
    public $SectionManager;
    /** @var EmailBuilderOptionsDTO */
    public $Options;
    /** @var SectionRenderer[] */
    public $Sections;
    /** @var OrderRetriever */
    public $OrderRetriever;

    private $emailResourcesURL='';
    public $OverrideResourceURL='';
    public function __construct($loader,$options, $orderRetriever)
    {
        $this->OrderRetriever=$orderRetriever;
        $this->Loader=$loader;

        if(count($options->ContentOptions->Rows)>0)
        {
            $options->ContentOptions->Sections=[];
            $options->ContentOptions->Sections[]=(new SectionOptionsDTO());
            ($options->ContentOptions->Sections[0])->LoadDefaultValues();
            $options->ContentOptions->Sections[0]->Rows=$options->ContentOptions->Rows;
            $options->ContentOptions->Rows=[];

        }

        $this->Sections=[];
        $this->GetTwigManager();
        parent::__construct($options, null);
        $this->SectionManager=new SectionManager($this);
    }

    public function IsEmpty(){
        foreach($this->Sections as $currentSection)
            if(!$currentSection->IsEmpty())
                return false;
        return true;
    }

    public function GetHeaders()
    {
        $headers=[];
        $headers[]='Content-Type: text/html; charset=UTF-8';
        $fromEmail=$this->GetFromRow();
        if($fromEmail!='')
            $headers[]=$fromEmail;
        $bcc=$this->ParseEmail($this->Options->HeaderOptions->BCC);
        if($bcc!='')
            $headers[]='Bcc: '.$bcc;

        $cc=$this->ParseEmail($this->Options->HeaderOptions->CC);
        if($cc!='')
            $headers[]='Cc: '.$cc;

        $replyTo=$this->GetReplyToRow();
        if($replyTo!='')
            $headers[]='reply-to: '.$replyTo;

        return $headers;
    }

    private function GetReplyToRow()
    {
        $fromName=$this->Options->HeaderOptions->FromName;
        $replyTo=trim($this->ParseEmail($this->Options->HeaderOptions->ReplyTo));

        if($replyTo==''||!filter_var($replyTo,FILTER_VALIDATE_EMAIL))
            return '';






        if(trim($fromName)=='')
            $fromName=get_bloginfo('name');

        return 'From: '.$fromName.' <'.$replyTo.'>';
    }

    public function GetFromRow(){
        $fromName=$this->Options->HeaderOptions->FromName;
        $fromEmail=$this->Options->HeaderOptions->FromEmailAddress;

        if(empty($fromName))
            $fromName = get_option( 'woocommerce_email_from_name' ,'');

        if(empty($fromEmail))
            $fromEmail = get_option( 'woocommerce_email_from_address' ,'');

        if($fromName==''&&$fromEmail=='')
            return '';
        if(trim($fromName)=='')
            $fromName=get_bloginfo('name');

        if(trim($fromEmail)=='')
            $fromEmail=apply_filters('wp_mail_from',get_option('admin_email'));

        return 'From: '.$fromName.' <'.$fromEmail.'>';



    }

   public function GetFilesToSave($validateFiles=true,$basePath='')
   {
       $files=[];
       foreach($this->Sections as $currentSection)
       {
           foreach($currentSection->Rows as $currentRow)
           {
               foreach($currentRow->Columns as $currentColumn)
               {
                   foreach($currentColumn->Blocks as $currentBlock)
                   {
                       $files=array_merge($files,$currentBlock->GetFileToSave($validateFiles,$basePath));
                   }
               }
           }
       }

       return $files;

   }

    public function GetEmailResourcesURL()
    {
        if($this->OverrideResourceURL!='')
            return $this->OverrideResourceURL;
        if($this->emailResourcesURL=='')
        {
            $fileManager=new FileManager($this->Loader);
            $this->emailResourcesURL=$fileManager->GetEmailResourcesFolderURL().$this->Options->Id.'/';
        }

        return $this->emailResourcesURL;

    }

    public function GetEmailResourcesPath()
    {
        $fileManager=new FileManager($this->Loader);
        return $fileManager->GetEmailResourcesFolderPath().$this->Options->Id.'/';


    }

    public function Initialize()
    {
        parent::Initialize();
    }

    public function GetSubject()
    {
        return SimpleTextRenderer::GetText($this->OrderRetriever,$this->Options->HeaderOptions->Subject);
    }


    protected function GetTemplateName()
    {
        return 'TwigManager/Renderers/EmailRenderer.twig';
    }

    public function GetSectionOptions()
    {
        return $this->Options->ContentOptions->Sections;
    }



    protected function InternalInitialize()
    {
        $this->SectionManager->Initialize();
    }

    public function GetChildren()
    {
        return $this->Sections;
    }

    public function GetToEmail(){
        return $this->ParseEmail($this->Options->HeaderOptions->To);
    }

    /**
     * @param $emailList EmailAddressDTO[]
     * @return string
     */
    private function ParseEmail($emailList){
        $emailsToReturn=[];
        foreach($emailList as $currentEmailOptions)
        {
            $found=false;
            $email='';
            switch ($currentEmailOptions->Type)
            {
                case 'Field':
                    $field=$this->OrderRetriever->GetFieldById($currentEmailOptions->Value);
                    if($field==null)
                        break;
                    $email=trim($field->ToText());
                    break;
                case 'Fixed':
                    $email=trim($currentEmailOptions->Value);
                    break;
                case 'Custom':
                    $customField=$this->GetCustomField($currentEmailOptions->Value,null,$this->OrderRetriever,$this);
                    $email=$customField->ToText();
            }

            if($email!=null&&filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                $emailsToReturn[]=$email;
            }

        }
        return implode(',',$emailsToReturn);
    }

    public function GetCustomField($customFieldId,$options,$orderValueRetriever,$parent)
    {
        $customFieldOptions=null;
        foreach ($this->Options->CustomFields as $currentCustomField)
            if($currentCustomField->Id==$customFieldId)
            {
                return new CustomField($options,$orderValueRetriever,$parent,$currentCustomField);
            }

        return null;



    }


}