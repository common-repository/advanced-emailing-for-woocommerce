<?php

namespace rnadvanceemailingwc\Managers\ConditionManager;

use rnadvanceemailingwc\DTO\ConditionGroupOptionsDTO;

class ConditionGroup
{
    /** @var ConditionManager */
    public $Manager;
    /** @var ConditionGroupOptionsDTO */
    public $Options;
    /** @var ConditionLine[] */
    public $Lines;
    public function __construct($manager,$options)
    {
        $this->Manager=$manager;
        $this->Options=$options;

        foreach($this->Options->ConditionLines as $currentLine)
        {
            $this->Lines[]=new ConditionLine($this,$currentLine);
        }
    }

    public function IsValid(){
        foreach($this->Lines as $currentLine)
            if($currentLine->IsValid())
                return true;

        return false;
    }

    public function ExecuteCondition()
    {
        foreach($this->Lines as $currentLine)
            if(!$currentLine->ExecuteCondition())
                return false;

        return true;
    }
}