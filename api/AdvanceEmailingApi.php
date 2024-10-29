<?php

namespace rnadvanceemailingwc\api;

use rnadvanceemailingwc\core\db\core\EmailRepository;
use rnadvanceemailingwc\core\Loader;
use rnadvanceemailingwc\Fields\Core\OrderRetriever;
use rnadvanceemailingwc\Fields\Test\TestOrderRetriever;
use rnadvanceemailingwc\pr\SplittedOrder;
use rnadvanceemailingwc\TwigManager\Renderers\EmailRenderer;

class AdvanceEmailingApi
{
    /** @var Loader */
    public $loader;
    public function __construct()
    {
        $this->loader=Loader::$Instance;
    }

    public function GetEmailList(){
        $repository=new EmailRepository(Loader::$Instance);
        return $repository->GetEmailList();
    }

    /**
     * @param $EmailId
     * @param $order \WC_Order
     * @return bool
     */
    public function SendEmail($EmailId,  $order,$logMessage='',$logAddedByUser=false)
    {
        $repository=new EmailRepository($this->loader);
        $emailOptions=$repository->GetEmailOptions($EmailId);
        if($emailOptions==null||$order==null)
            return false;

        $result=false;

        if($emailOptions->ContentOptions->SplitOrder)
        {
            $splitOrder=new SplittedOrder($order->get_id());
            foreach ($splitOrder->GetAllItems() as $currentItem)
            {
                $splitOrder->ClearShowedItems();
                $splitOrder->ShowItem($currentItem->get_id());
                $result= $this->ExecuteSendingEmail($emailOptions,$splitOrder);

                if(!$result)
                    return false;
            }
        }else{
            $result= $this->ExecuteSendingEmail($emailOptions,$order);
        }

        if($result&&$logMessage!='')
        {
            $order->add_order_note(str_replace('[email_name]',$emailOptions->Name,$logMessage), false, $logAddedByUser);
        }

        return $result;


    }

    public function RenderPreview($templateId,$orderId=null)
    {
        $emailRepository=new EmailRepository($this->loader);
        $options=$emailRepository->GetEmailOptions($templateId);

        if($orderId!=null)
        {
            $order=wc_get_order($orderId);
            if($order==null)
                throw new \Exception('Order not found');
            $retriever=new OrderRetriever($this->loader,$order);

        }else
            $retriever=new TestOrderRetriever($this->loader);


        $emailRenderer=new EmailRenderer($this->loader,$options,$retriever);
        $emailRenderer->Initialize();

        echo $emailRenderer->Render();
    }

    public function GetEmailRenderedByTemplateId($emailId,$order)
    {
        $repository=new EmailRepository($this->loader);
        $emailOptions=$repository->GetEmailOptions($emailId);
        if($emailOptions==null||$order==null)
            return null;

        $retriever=new OrderRetriever($this->loader,$order);
        $emailRenderer= new EmailRenderer($this->loader,$emailOptions,$retriever);
        $emailRenderer->Initialize();
        return $emailRenderer;
    }


    private function ExecuteSendingEmail($emailOptions,$order)
    {


        $retriever=new OrderRetriever($this->loader,$order);
        $emailRenderer=new EmailRenderer($this->loader,$emailOptions,$retriever);
        $emailRenderer->Initialize();
        $content= $emailRenderer->Render();


        $attachments=[];
        $attachments=apply_filters('aefwc-get-attachments',$attachments,$order,$emailOptions);

        $toEmail=$emailRenderer->GetToEmail();
        if(count($emailRenderer->Options->HeaderOptions->To)>0&&$toEmail=='')
            return false;
        return \wp_mail($toEmail,$emailRenderer->GetSubject(),strval($content),$emailRenderer->GetHeaders(),$attachments);
    }


}