<?php

namespace rnadvanceemailingwc\ajax;

use rnadvanceemailingwc\core\db\core\EmailRepository;
use rnadvanceemailingwc\DTO\EmailBuilderOptionsDTO;
use rnadvanceemailingwc\Fields\Core\OrderRetriever;
use rnadvanceemailingwc\Fields\Test\TestOrderRetriever;
use rnadvanceemailingwc\Managers\FileManager;
use rnadvanceemailingwc\pr\OrderScanner\OrderScanner;
use rnadvanceemailingwc\TwigManager\Renderers\EmailRenderer;
use rnadvanceemailingwc\Utilities\Sanitizer;

class EmailBuilderAjax extends AjaxBase
{

    function GetDefaultNonce()
    {
        return 'RNEmailBuilder';
    }

    protected function RegisterHooks()
    {
        $this->RegisterPrivate('save_email','SaveEmail');
        $this->RegisterPrivate('preview','Preview');
        $this->RegisterPublic('preview_by_id','PreviewById',false);
        $this->RegisterPrivate('validating_order','ValidatingOrder');
        $this->RegisterPrivate('send_test_email','SendTestEmail');
        $this->RegisterPrivate('scan_order','InspectOrder');
    }

    public function PreviewById()
    {
        $nonce=$_GET['nonce'];
        $templateId=intval($_GET['id']);
        $orderId=null;

        if(isset($_GET['order']))
            $orderId=intval($_GET['order']);


        $action='rnadvanceemailingwc_preview';
        if($orderId!=null)
            $action='rnadvanceemailingwc_preview_'.$orderId;
        if(!wp_verify_nonce($nonce,$action))
            $this->SendErrorMessage('Invalid nonce');

        RNADEM()->RenderPreview($templateId,$orderId);


    }
    public function InspectOrder()
    {
        $orderNumber=$this->GetRequired('OrderNumber');
        $items=(new OrderScanner($orderNumber))->Scan();
        $this->SendSuccessMessage($items);
    }
    public function SendTestEmail(){
        $sendOptions=$this->GetRequired('SendOptions');
        $options=$this->GetRequired('Options');

        $address=$sendOptions->Address;
        $type=$sendOptions->Type;
        $orderNumber=$sendOptions->OrderNumber;
        if(!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            $this->SendErrorMessage('Invalid email address');
        }

        $orderRetriever=null;
        if($type=='real') {
            $orderNumber =intval($sendOptions->OrderNumber);
            $order=wc_get_order($orderNumber);

            if($order==false)
                $this->SendErrorMessage('Invalid order number');

            $orderRetriever=new OrderRetriever($this->Loader,$order);
        }else
            $orderRetriever=new TestOrderRetriever($this->Loader);


        $emailBuilder=(new EmailBuilderOptionsDTO())->Merge($options);
        $emailRenderer=new EmailRenderer($this->Loader,$emailBuilder,$orderRetriever);
        $files=$emailRenderer->GetFilesToSave();
        if(count($files)>0)
        {
            $fileManager=new FileManager($this->Loader);
            $path=$fileManager->GetTemporalEmailResourcePath();
            foreach($files as $currentFile)
            {
                move_uploaded_file($_FILES[$currentFile['id']]['tmp_name'],$path.$currentFile['file']);
            }

            $emailRenderer->OverrideResourceURL=$fileManager->GetTemporalEmailResourceURL();

        }
        $emailRenderer->Initialize();
        $content= $emailRenderer->Render();



        wp_mail($address,$emailRenderer->GetSubject(),strval($content),[$emailRenderer->GetFromRow(),'Content-Type: text/html; charset=UTF-8']);
        $this->SendSuccessMessage('Email send successfully');

    }

    public function ValidatingOrder(){
        $orderNumber=$this->GetRequiredNumber('OrderNumber');
        if(get_post_type($orderNumber)=='shop_order')
            $this->SendSuccessMessage(true);
        else
            $this->SendSuccessMessage(false);

    }

    public function Preview(){
        $options=$this->GetRequired('Options');
        /** @var OrderRetriever $retriever */
        $retriever=null;
        if($this->GetRequired('PreviewType')=='fake')
        {
            $retriever=new TestOrderRetriever($this->Loader);
        }else{
            $orderNumber=$this->GetRequiredNumber('OrderNumber');
            $order=wc_get_order($orderNumber);
            if($order==null) {
                echo "Order not found";
            }
            $retriever=new OrderRetriever($this->Loader,$order);
        }
        $emailBuilder=(new EmailBuilderOptionsDTO())->Merge($options);
        $emailRenderer=new EmailRenderer($this->Loader,$emailBuilder,$retriever);

        $files=$emailRenderer->GetFilesToSave();
        if(count($files)>0)
        {
            $fileManager=new FileManager($this->Loader);
            $path=$fileManager->GetTemporalEmailResourcePath();
            foreach($files as $currentFile)
            {
                move_uploaded_file($_FILES[$currentFile['id']]['tmp_name'],$path.$currentFile['file']);
            }

            $emailRenderer->OverrideResourceURL=$fileManager->GetTemporalEmailResourceURL();

        }
        $emailRenderer->Initialize();

        echo $emailRenderer->Render();
    }

    public function SaveEmail(){
        $emailBuilderOptions=(new EmailBuilderOptionsDTO());
        $emailBuilderOptions->Merge($this->GetRequired('Options'));
        $emailRepository=new EmailRepository($this->Loader);

        try{
            $emailRepository->SaveEmail($emailBuilderOptions);
        }catch (\Exception $exception)
        {
            $this->SendException($exception);
        }

        $this->SendSuccessMessage($emailBuilderOptions->Id);

    }
}