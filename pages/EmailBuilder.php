<?php

namespace rnadvanceemailingwc\pages;

use rnadvanceemailingwc\core\db\core\EmailRepository;
use rnadvanceemailingwc\core\Integration\IntegrationURL;
use rnadvanceemailingwc\core\LibraryManager;
use rnadvanceemailingwc\core\PageBase;
use rnadvanceemailingwc\pr\Managers\FontFamilyManager;

class EmailBuilder extends PageBase
{

    public function Render()
    {
        $this->Loader->CheckIfPDFAdmin();
        $libraryManager=new LibraryManager($this->Loader);
        $libraryManager->AddDropdownButton();
        $libraryManager->AddCoreUI();
        $libraryManager->AddWPTable();
        $libraryManager->AddDialog();
        $libraryManager->AddTabs();
        $libraryManager->AddSwitchContainer();
        $libraryManager->AddInputs();
        $libraryManager->AddTextEditor();
        $libraryManager->AddPreMadeDialog();
        $libraryManager->AddContextMenu();
        $libraryManager->AddFormulaParser();
        $libraryManager->AddAlertDialog();
        $libraryManager->AddSingleLineGenerator();

        $dependencies=['@EmailCondition'];
        $this->Loader->AddScript('EmailCondition','js/dist/RNEmailConditionDesigner_bundle.js');
        $this->Loader->AddStyle('standard','TwigManager/Templates/Standard/Style.css');

        $this->Loader->AddScript('list','js/dist/RNEmailEmailBuilder_bundle.js',array_merge($libraryManager->GetDependencyHooks(),$dependencies));
        $this->Loader->AddStyle('list','js/dist/RNEmailEmailBuilder_bundle.css');
        $this->Loader->AddStyle('EmailBuilderStyles','TwigManager/Renderers/EmailRenderer.css');
        $previewNonce = \wp_create_nonce('avanceemailwc_preview');
        $statusList=[];
        foreach (wc_get_order_statuses() as $key=>$value)
        {
            if(strpos($key,'wc-')===0)
                $key=substr($key,3);
            $statusList[]=["Label"=>$value,"Value"=>$key];

        }
        wp_enqueue_media();

        $repository=new EmailRepository($this->Loader);
        $emailOptions=null;
        if(isset($_GET['emailid']))
            $emailOptions=$repository->GetEmailOptions(intval($_GET['emailid']));

        $fonts=[];
        if($this->Loader->IsPR())
        {
            $fontManager=new FontFamilyManager();
            $fonts=$fontManager->GetFontFamilyNames();
        }

        $this->Loader->LocalizeScript('rednaoEmailDesigner', 'list', 'RNEmailBuilder', array(
            'Options'=>$emailOptions,
            'Fonts'=>$fonts,
            'Records' => [],
            'Templates' => [],
            'PluginURL'=>$this->Loader->URL,
            'IsPr' => $this->Loader->IsPR(),
            'Count' => 10,
            'RowTemplates'=>[],
            'OrderStatus'=>$statusList,
            'URL' => $this->Loader->URL,
            'TemplatePreviewURL' => 'https://allinoneforms.rednao.com/form-demo-2/?templateId=',
            'ajaxurl' => IntegrationURL::AjaxURL(),
            'PreviewURL' => IntegrationURL::AjaxURL() . '?&_nonce=' . wp_create_nonce($this->Loader->Prefix.'_RNEmailBuilder').'&action='.$this->Loader->Prefix.'_preview',
            'PageURL' => IntegrationURL::PageURL('rnadvanceemailing')));
        echo '<div id="App" style=" position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 99999;
    background-color: white;">
        <style>                                  
            .lds-hourglass {
              display: inline-block;
              position: relative;
              width: 80px;
              height: 80px;
            }
            .lds-hourglass:after {
              content: " ";
              display: block;
              border-radius: 50%;
              width: 0;
              height: 0;
              margin: 8px;
              box-sizing: border-box;
              border: 32px solid black;
              border-color: black transparent black transparent;
              animation: lds-hourglass 1.2s infinite;
            }
            @keyframes lds-hourglass {
              0% {
                transform: rotate(0);
                animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
              }
              50% {
                transform: rotate(900deg);
                animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
              }
              100% {
                transform: rotate(1800deg);
              }
            }
 
        </style>
        <div style="width:100%;height:100%;justify-content: center;align-items: center;font-size: 20px;font-weight: bold;display: flex;flex-direction: column;">
            <div class="lds-hourglass"></div>
            <div style="font-size: 30px;margin-top: 10px;">' . __("Loading email builder...") . '</div>
        </div>';
    }
}