<?php

namespace rnadvanceemailingwc\DTO\core\Factories;

use rnadvanceemailingwc\DTO\AfterXTimeScheduleOptionsDTO;
use rnadvanceemailingwc\DTO\XDayOfMonthScheduleDTO;

class ScheduleFactory
{
    public static function GetClass($value)
    {
        if($value==null)
            return null;

        switch ($value->Type)
        {
            case 'after_time':
                return (new AfterXTimeScheduleOptionsDTO())->Merge($value);
            case 'specific_date':
                return (new XDayOfMonthScheduleDTO())->Merge($value);
        }
    }
}