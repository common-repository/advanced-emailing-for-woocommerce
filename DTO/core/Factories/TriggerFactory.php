<?php

namespace rnadvanceemailingwc\DTO\core\Factories;

use rnadvanceemailingwc\core\Exception\FriendlyException;
use rnadvanceemailingwc\DTO\OrderStatusChangeTriggerOptionsDTO;
use rnadvanceemailingwc\DTO\TriggerBaseOptionsDTO;

class TriggerFactory
{
    public static function GetTriggerList($triggers)
    {
        if($triggers==null)
            return null;
        $array=[];
        foreach($triggers as $currentTrigger)
            $array[]=TriggerFactory::GetTrigger($currentTrigger);

        return $array;
    }

    private static function GetTrigger($trigger)
    {

        switch ($trigger->Type)
        {
            case 'order_status_change':
                return (new OrderStatusChangeTriggerOptionsDTO())->Merge($trigger);
            case 'order_created':
                return (new TriggerBaseOptionsDTO())->Merge($trigger);
            default:
                return null;
        }

    }

}