<?php

namespace rnadvanceemailingwc\Managers\ConditionManager;

use rnadvanceemailingwc\DTO\ConditionBaseOptionsDTO;
use rnadvanceemailingwc\DTO\ConditionGroupOptionsDTO;
use rnadvanceemailingwc\Fields\Core\OrderRetriever;

class ConditionManager
{

    /** @var ConditionBaseOptionsDTO */
    public $ConditionOptions;
    /** @var ConditionGroup[] */
    public $Groups;
    /** @var OrderRetriever */
    public $Retriever;
    public function __construct($retriever)
    {
        $this->Retriever=$retriever;
        $this->Groups=[];

    }

    /**
     * @param $condition ConditionBaseOptionsDTO
     * @return bool
     */
    public function ShouldProcess($condition)
    {
        $this->ConditionOptions=$condition;
        $this->Groups=[];
        if($condition==null||count($condition->ConditionGroups)==0)
            return false;

        foreach($condition->ConditionGroups as $currentGroup)
        {
            $this->Groups[]=new ConditionGroup($this,$currentGroup);
        }

        if(!$this->IsValid())
            return false;

        foreach($this->Groups as $currentGroup)
            if($currentGroup->IsValid()&&$currentGroup->ExecuteCondition())
                return true;

        return false;


    }

    public function IsValid(){
        foreach ($this->Groups as $currentGroup)
            if($currentGroup->IsValid())
                return true;

        return false;
    }
}