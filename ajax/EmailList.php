<?php

namespace rnadvanceemailingwc\ajax;

use rnadvanceemailingwc\core\db\core\EmailRepository;
use rnadvanceemailingwc\DTO\EmailBuilderOptionsDTO;
use rnadvanceemailingwc\Managers\ExportManager;
use rnadvanceemailingwc\Managers\FileManager;
use rnadvanceemailingwc\Managers\ImportManager;
use rnadvanceemailingwc\pr\Utilities\Activator;
use rnadvanceemailingwc\Utilities\Sanitizer;

class EmailList extends AjaxBase
{

    function GetDefaultNonce()
    {
        return 'RNEmailList';
    }

    protected function RegisterHooks()
    {
        $this->RegisterPrivate('CreateEmailTemplate','CreateEmailTemplate');
        $this->RegisterPrivate('CreateEmailTemplateUsingFile','CreateEmailTemplateUsingFile');
        $this->RegisterPrivate('clone_email','CloneEmail');
        $this->RegisterPrivate('delete_email','DeleteEmail');
        $this->RegisterPrivate('delete_email','DeleteEmail');
        $this->RegisterPrivate('export_email_template','ExportTemplate');
        $this->RegisterPrivate('import_email_template','ImportTemplate');
        $this->RegisterPrivate('list_email','ListEmail');
        $this->RegisterPrivate('activate_license','ActivateLicense');
        $this->RegisterPrivate('deactivate_license','DeactivateLicense');

    }

    public function CreateEmailTemplateUsingFile()
    {

        if(!isset($_FILES['File']))
        {
            $this->SendErrorMessage('Template not found');
        }

        $importer=new ImportManager($this->Loader);
        try{
            $options=$importer->Import($_FILES['File']['tmp_name']);
        }catch (\Exception $e)
        {
            $this->SendErrorMessage($e->getMessage());
            die();
        }


        $this->SendSuccessMessage(['Name'=>$options->Name,'Id'=>$options->Id]);


    }
    public function ListEmail(){
        $search=$this->GetRequired('Search');
        $repository=new EmailRepository($this->Loader);
        $this->SendSuccessMessage(['Result'=>$repository->GetEmailList($search),'Count'=>$repository->GetEmailListCount($search)]);
    }

    public function DeleteEmail(){
        $repository=new EmailRepository($this->Loader);
        $repository->DeleteEmail(intval($this->GetRequired('Id')));
        $this->SendSuccessMessage(true);
    }

    public function ActivateLicense(){

        $licenseKey=$this->GetRequired('LicenseKey');
        $expirationDate=$this->GetRequired('ExpirationDate');
        $url=$this->GetRequired('URL');
        (new Activator())->SaveLicense($licenseKey,$expirationDate,$url);
        $this->SendSuccessMessage('');
    }



    public function ImportTemplate(){
        if(!isset($_FILES['TemplateToImport']))
        {
            $this->SendErrorMessage('Template not found');
        }

        $importer=new ImportManager($this->Loader);
        try{
            $options=$importer->Import($_FILES['TemplateToImport']['tmp_name']);
        }catch (\Exception $e)
        {
            $this->SendErrorMessage($e->getMessage());
            die();
        }


        $this->SendSuccessMessage(['Name'=>$options->Name,'Id'=>$options->Id]);
    }

    public function ExportTemplate(){
        $emailId=intval($this->GetRequired('EmailId'));

        $exportManager=new ExportManager($this->Loader);
        try {
            $path=$exportManager->Export($emailId);

            header("Content-Type: application/zip");
            header("Content-Disposition: attachment; filename=".$exportManager->Options->Name.'.zip');
            header("Content-Length: " . filesize($path));
            readfile($path);

        }catch (\Exception $e)
        {
            echo Sanitizer::SanitizeHTML($e->getMessage());
            die();
        }

        $exportManager->Remove();
        die();
    }

    public function CreateEmailTemplate(){
        $templateId=$this->GetRequired('TemplateId');
        $templatePath=$this->Loader->DIR.'Templates/Locals/'.$templateId.'/Template.json';
        if(!file_exists($templatePath))
            $this->SendErrorMessage('Template not found');
        $options=json_decode(file_get_contents($templatePath));
        if($options==false)
            $this->SendErrorMessage('Template not found');

        /** @var EmailBuilderOptionsDTO $templateOption */
        $templateOption=(new EmailBuilderOptionsDTO())->Merge($options);
        $templateOption->Id=0;

        $repository=new EmailRepository($this->Loader);
        $repository->SaveEmail($templateOption,true);

        $this->SendSuccessMessage(['Id'=>$templateOption->Id]);


    }

    public function CloneEmail()
    {
        $name=$this->GetRequired('Name');
        $id=Sanitizer::SanitizeNumber($this->GetRequired('Id'));

        $repository=new EmailRepository($this->Loader);

        $email=$repository->GetEmailOptions($id);
        $email->Id=0;
        $email->Name=$name;

        try{
            $repository->SaveEmail($email);;
        }catch (\Exception $e)
        {
            $this->SendException($e);
        }

        $this->SendSuccessMessage($email->Id);

    }


    public function DeactivateLicense(){
        Activator::DeleteLicense();

        $this->SendSuccessMessage('');
    }

}