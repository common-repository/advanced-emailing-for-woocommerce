<?php

namespace rnadvanceemailingwc\Managers\TriggerManager;

use rnadvanceemailingwc\core\db\core\EmailRepository;
use rnadvanceemailingwc\core\Loader;
use rnadvanceemailingwc\DTO\ConditionBaseOptionsDTO;
use rnadvanceemailingwc\DTO\TriggerBaseOptionsDTO;
use rnadvanceemailingwc\Fields\Core\OrderRetriever;
use rnadvanceemailingwc\Managers\ConditionManager\ConditionManager;
use rnadvanceemailingwc\pr\Managers\ScheduleManager\ScheduleManager;

class TriggerManager
{
    /** @var Loader */
    public $loader;
    /** @var EmailRepository */
    public $Repository;
    public function __construct($loader)
    {
        $this->loader=$loader;
        $this->Repository=new EmailRepository($loader);
    }


    public static $TriggerManager;
    public static function Instance(){
        if(self::$TriggerManager==null)
            self::$TriggerManager=new TriggerManager(RNADEM()->loader);
        return self::$TriggerManager;
    }

    public function InitializeHooks()
    {
        add_filter('woocommerce_order_status_changed',array($this,'OrderStatusChange'),10,3);
        add_action('woocommerce_checkout_update_order_meta',array($this,'OrderCreated'),10,2);
    }

    public function OrderCreated($orderId,$data)
    {
        $trigger=$this->Repository->GetTriggersByType('order_created');
        $retriever=null;
        foreach($trigger as $currentTrigger)
        {
            if($retriever==null)
            {
                $order=wc_get_order($orderId);
                if($order==null)
                    continue;
                $retriever=new OrderRetriever($this->loader,$order);
            }


            if($this->ConditionIsValid($currentTrigger,$retriever))
            {
                if($this->MaybeSchedule($currentTrigger->EmailId,$orderId))
                    return;
                RNADEM()->SendEmail($currentTrigger->EmailId,$order);
            }
        }
    }

    public function OrderStatusChange($orderId,$oldStatus,$newStatus)
    {
        $trigger=$this->Repository->GetTriggersByType('order_status_change');
        $retriever=null;
        foreach($trigger as $currentTrigger)
        {
            if((in_array($oldStatus,$currentTrigger->Options->FromStatus)||count($currentTrigger->Options->FromStatus)==0)
                &&(in_array($newStatus,$currentTrigger->Options->ToStatus)||count($currentTrigger->Options->ToStatus)==0))
            {
                if($retriever==null)
                {
                    $order=wc_get_order($orderId);
                    if($order==null)
                        continue;
                    $retriever=new OrderRetriever($this->loader,$order);
                }


                if($this->ConditionIsValid($currentTrigger,$retriever))
                {
                    if($this->MaybeSchedule($currentTrigger->EmailId,$orderId))
                        return;
                    RNADEM()->SendEmail($currentTrigger->EmailId,$order);
                }
            }
        }
    }

    private function MaybeSchedule($emailId,$orderId)
    {
        $repository=new EmailRepository($this->loader);
        $options=$repository->GetEmailOptions($emailId);
        if($options!=null&&$options->ContentOptions->Schedule!=null)
        {
            $scheduleManager=new ScheduleManager();
            return $scheduleManager->ScheduleEmail($options,$orderId);
        }

        return false;
    }


    /**
     * @param $trigger TriggerBaseOptionsDTO
     * @return boolean
     */
    public function ConditionIsValid($trigger,$retriever)
    {
        if(!$this->loader->IsPR())
            return true;

        if($trigger->Options->Condition==null)
            return true;



        $condition =(new ConditionBaseOptionsDTO())->Merge($trigger->Options->Condition);
        $manager=new ConditionManager($retriever);
        if ($condition == null)
            return true;

        return $manager->ShouldProcess($condition);

    }



}