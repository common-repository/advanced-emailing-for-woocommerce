<?php

namespace rnadvanceemailingwc\Managers\ConditionManager\Comparators\Core;

use rnadvanceemailingwc\DTO\ConditionBaseOptionsDTO;
use rnadvanceemailingwc\DTO\ConditionLineOptionsDTO;
use rnadvanceemailingwc\DTO\ConditionLineTypeEnumDTO;
use rnadvanceemailingwc\DTO\SubTypeEnumDTO;
use rnadvanceemailingwc\Managers\ConditionManager\Comparators\DateComparator;
use rnadvanceemailingwc\Managers\ConditionManager\Comparators\MultipleOptionsComparator;
use rnadvanceemailingwc\Managers\ConditionManager\Comparators\NumericComparator;
use rnadvanceemailingwc\Managers\ConditionManager\Comparators\StandardComparator;

class ComparatorFactory
{
    /**
     * @param $condition ConditionLineOptionsDTO
     * @return ComparatorBase
     */
    public static function GetComparator($condition){
        switch ($condition->SubType)
        {
            case SubTypeEnumDTO::$MultipleValues:
                return new MultipleOptionsComparator();
            case SubTypeEnumDTO::$Date:
                return new DateComparator();
            case SubTypeEnumDTO::$Numeric:
                return new NumericComparator();
            default:
                return new StandardComparator();
        }
    }
}