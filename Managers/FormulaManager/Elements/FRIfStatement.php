<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;
use rnadvanceemailingwc\Managers\FormulaManager\FRFactory;

class FRIfStatement extends FRBase
{
    /** @var FRBase */
    private $Condition;
    /** @var FRBase */
    private $TrueAction;
    /** @var FRBase */
    private $FalseAction;

    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);

        $this->Condition = FRFactory::GetFRElement($this->Options->Con, $this);
        $this->TrueAction = FRFactory::GetFRElement($this->Options->Tr, $this);
        if (isset($this->Options->Fa)&&$this->Options->Fa!=null)
            $this->FalseAction = FRFactory::GetFRElement($this->Options->Fa, $this);

    }

    public function Parse()
    {
        if ($this->Condition->Parse())
            return $this->TrueAction->Parse();
        else
        {
            if ($this->FalseAction != null)
                return $this->FalseAction->Parse();
        }
    }
}