<?php

namespace rnadvanceemailingwc\pages;

use rnadvanceemailingwc\core\db\core\EmailRepository;
use rnadvanceemailingwc\core\Integration\IntegrationURL;
use rnadvanceemailingwc\core\LibraryManager;
use rnadvanceemailingwc\core\PageBase;
use rnadvanceemailingwc\pr\Utilities\Activator;

class AdvanceEmailList extends PageBase
{

    public function Render()
    {
        $this->Loader->CheckIfPDFAdmin();
        $libraryManager=new LibraryManager($this->Loader);
        $libraryManager->AddCoreUI();
        $libraryManager->AddWPTable();
        $libraryManager->AddDialog();
        $libraryManager->AddTabs();
        $libraryManager->AddInputs();
        $libraryManager->AddPreMadeDialog();
        $libraryManager->AddAlertDialog();
        $this->Loader->AddScript('list','js/dist/RNEmailEmailList_bundle.js',$libraryManager->GetDependencyHooks());
        $this->Loader->AddStyle('list','js/dist/RNEmailEmailList_bundle.css');
        $previewNonce = \wp_create_nonce('avanceemailwc_preview');

        $lisense='';
        if($this->Loader->IsPR())
            $lisense=Activator::GetLicense();


        $repository=new EmailRepository($this->Loader);
        $this->Loader->LocalizeScript('RednaoEmailListVar ', 'list', 'RNEmailList', array(
            'PreviewNonce'=>wp_create_nonce('rnadvanceemailingwc_preview'),
            'Records' => $repository->GetEmailList(),
            'BaseUrl'=>get_home_url(),
            'LicenseKey'=>$lisense!=null?$lisense->LicenseKey:'',
            'LicenseURL'=>$lisense!=null?$lisense->URL:'',
            'Templates' => \json_decode(\file_get_contents($this->Loader->DIR . 'Templates/Locals/LocalTemplateList.json')),
            'Global' => \json_decode(\file_get_contents($this->Loader->DIR . 'Templates/Global.json')),
            'IsPr' => $this->Loader->IsPR(),
            'Count' => $repository->GetEmailListCount(),
            'URL' => $this->Loader->URL,
            'TemplatePreviewURL' => 'https://allinoneforms.rednao.com/form-demo-2/?templateId=',
            'ajaxurl' => IntegrationURL::AjaxURL(),
            'PreviewURL' => IntegrationURL::PreviewURL() . '&_nonce=' . $previewNonce,
            'PageURL' => IntegrationURL::PageURL('rnadvanceemailing')));
        echo '<div id="App"></div>';
    }
}