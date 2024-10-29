<?php

namespace rnadvanceemailingwc\Managers\ConditionManager\Comparators;

use rnadvanceemailingwc\core\Utils\ArrayUtils;
use rnadvanceemailingwc\DTO\ConditionLineOptionsDTO;
use rnadvanceemailingwc\Fields\Core\OrderRetriever;
use rnadvanceemailingwc\Managers\ConditionManager\Comparators\Core\ComparatorBase;
use rnadvanceemailingwc\Utilities\Sanitizer;

class MultipleOptionsComparator extends ComparatorBase
{

    public function Compare($retriever, $conditionLine)
    {
        $field=$retriever->GetFieldById($conditionLine->FieldId);
        if($field==null)
            return true;

        $fieldValue=strtolower($field->ToText());

        $value=$conditionLine->Value;
        if(!is_array($value))
            $value=[$value];

        $stringValue=[];
        foreach($value as $currentValue)
            $stringValue[]=strtolower(Sanitizer::SanitizeString($currentValue));

        switch ($conditionLine->Comparison)
        {
            case 'Contains':
                return ArrayUtils::Some($stringValue,function ($item)use($fieldValue){
                    return $fieldValue==$item;
                });
            case 'NotContains':
                return !ArrayUtils::Some($stringValue,function ($item)use($fieldValue){
                    return $fieldValue==$item;
                });
            case 'IsEmpty':
                return $fieldValue=='';
            case 'IsNotEmpty':
                return $fieldValue!='';

        }

        return true;
    }
}