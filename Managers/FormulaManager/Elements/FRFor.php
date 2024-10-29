<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;
use rnadvanceemailingwc\Managers\FormulaManager\FRFactory;
use rnadvanceemailingwc\Managers\FormulaManager\Utilities\FRUtilities;

class FRFor extends FRBase
{
    /** @var FRBase */
    private $Var;
    /** @var FRBase */
    private $Cond;
    /** @var FRBase */
    private $Inc;
    /** @var FRBase */
    private $Statement;

    public $ShouldBreak = false;

    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);

        $this->Var = FRFactory::GetFRElement($Options->V, $this);
        if ($Options->C != null)
            $this->Cond = FRFactory::GetFRElement($Options->C, $this);

        if ($Options->I != null)
            $this->Inc = FRFactory::GetFRElement($Options->I, $this);

        $this->Statement = FRFactory::GetFRElement($Options->S, $this);
    }

    public function Parse()
    {
        $this->ShouldBreak = false;
        $this->Var->Parse();
        $result = null;
        while ($this->Cond == null || $this->Cond->Parse() == true)
        {
            $result = $this->Statement->Parse();
            if ($this->ShouldBreak)
                return $result;
            if ($this->Inc != null)
                $this->Inc->Parse();
        }

        return $result;

    }


    public function ReturnWasExecuted()
    {
        $this->ShouldBreak = true;
        FRUtilities::NotifyReturnToParent($this);
    }

    public function BreakWasExecuted()
    {
        $this->ShouldBreak = true;
    }
}