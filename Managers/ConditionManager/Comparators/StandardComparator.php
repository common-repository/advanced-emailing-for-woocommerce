<?php

namespace rnadvanceemailingwc\Managers\ConditionManager\Comparators;

use Automattic\WooCommerce\Admin\Overrides\Order;
use rnadvanceemailingwc\DTO\ConditionLineOptionsDTO;
use rnadvanceemailingwc\Fields\Core\OrderRetriever;
use rnadvanceemailingwc\Managers\ConditionManager\Comparators\Core\ComparatorBase;
use rnadvanceemailingwc\Utilities\Sanitizer;

class StandardComparator extends ComparatorBase
{

    /**
     * @param $retriever OrderRetriever
     * @param $conditionLine ConditionLineOptionsDTO
     * @return bool
     */
    public function Compare($retriever, $conditionLine)
    {
        $field=$retriever->GetFieldById($conditionLine->FieldId);
        if($field==null)
            return true;

        $text=$field->ToText();
        $value=Sanitizer::SanitizeString($conditionLine->Value,'');
        switch ($conditionLine->Comparison)
        {
            case 'Equal':
                return $text==$value;
            case "NotEqual":
                return $text!=$value;
            case "IsEmpty":
                return $text=='';
            case "IsNotEmpty":
                return $text!='';
            case "Contains":
                return strpos($text,$value)!==false;
            case "NotContains":
                return strpos($text,$value)===false;
        }


        return true;
    }
}