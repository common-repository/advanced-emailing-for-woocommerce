<?php

namespace rnadvanceemailingwc\DTO\core\Factories;

use rnadvanceemailingwc\DTO\ConditionLineOptionsDTO;
use rnadvanceemailingwc\DTO\SubTypeEnumDTO;

class ConditionLineFactory
{
    /**
     * @param $conditionLineOptions ConditionLineOptionsDTO
     * @param $value
     * @return void
     */
    public static function GetValue($conditionLineOptions,$value)
    {
        if($conditionLineOptions->SubType==SubTypeEnumDTO::$MultipleValues)
        {
            if($value==''||!is_array($value))
                return [];

            return $value;
        }
    }
}