<?php

namespace rnadvanceemailingwc\Managers\ConditionManager\Comparators;

use rnadvanceemailingwc\DTO\ConditionLineOptionsDTO;
use rnadvanceemailingwc\Fields\Core\OrderRetriever;
use rnadvanceemailingwc\Managers\ConditionManager\Comparators\Core\ComparatorBase;
use rnadvanceemailingwc\Utilities\Sanitizer;

class NumericComparator extends ComparatorBase
{

    public function Compare($retriever, $conditionLine)
    {
        $field=$retriever->GetFieldById($conditionLine->FieldId);
        if($field==null)
            return true;

        $text=$field->ToNumber();
        $value=Sanitizer::SanitizeNumber($conditionLine->Value,'');
        switch ($conditionLine->Comparison)
        {
            case 'Equal':
                return $text==$value;
            case "NotEqual":
                return $text!=$value;
            case "GreaterThan":
                return $text>$value;
            case "GreaterOrEqualThan":
                return $text>=$value;
            case "LessThan":
                return $text<$value;
            case "LessOrEqualThan":
                return $text<=$value;
            case "IsEmpty":
                return $field->ToText()=='';
            case "IsNotEmpty":
                return $field->ToText()!='';

        }


        return true;
    }
}