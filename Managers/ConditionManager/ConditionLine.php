<?php

namespace rnadvanceemailingwc\Managers\ConditionManager;

use rnadvanceemailingwc\DTO\ConditionLineOptionsDTO;
use rnadvanceemailingwc\Managers\ConditionManager\Comparators\Core\ComparatorFactory;

class ConditionLine
{
    /** @var ConditionGroup */
    public $Group;
    /**
     * @var ConditionLineOptionsDTO
     */
    public $Options;
    public function __construct($group,$options)
    {
        $this->Group=$group;
        $this->Options=$options;
    }

    public function IsValid(){
        return $this->Options->FieldId!=''&&$this->Options->Comparison!='';
    }

    public function ExecuteCondition(){
        $retriever=$this->Group->Manager->Retriever;
        $field=$retriever->GetFieldById($this->Options->FieldId);
        $comparator=ComparatorFactory::GetComparator($this->Options);

        if($comparator==false||$field==false)
            return false;

        return $comparator->Compare($retriever,$this->Options);

    }


}