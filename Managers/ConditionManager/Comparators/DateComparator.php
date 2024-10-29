<?php

namespace rnadvanceemailingwc\Managers\ConditionManager\Comparators;

use rnadvanceemailingwc\DTO\ConditionLineOptionsDTO;
use rnadvanceemailingwc\Fields\Core\OrderRetriever;
use rnadvanceemailingwc\Managers\ConditionManager\Comparators\Core\ComparatorBase;
use rnadvanceemailingwc\Utilities\Sanitizer;

class DateComparator extends ComparatorBase
{

    public function Compare($retriever, $conditionLine)
    {
        $field=$retriever->GetFieldById($conditionLine->FieldId);
        if($field==null)
            return true;

        $fieldDate=$field->ToNumber();
        $conditionDate=$this->ValueToDate($conditionLine->Value);



        switch ($conditionLine->Comparison)
        {
            case 'Equal':
                return $fieldDate==$conditionDate;
            case "NotEqual":
                return $fieldDate!=$conditionDate;
            case "GreaterThan":
                return $fieldDate>$conditionDate;
            case "GreaterOrEqualThan":
                return $fieldDate>=$conditionDate;
            case "LessThan":
                return $fieldDate<$conditionDate;
            case "LessOrEqualThan":
                return $fieldDate<=$conditionDate;
            case "IsEmpty":
                return $field->ToText()=='';
            case "IsNotEmpty":
                return $field->ToText()!='';

        }


        return true;
    }

    public function ValueToDate($value,$dateToUse=null)
    {
        if(is_numeric($value))
            return $value;
        return false;

    }
}