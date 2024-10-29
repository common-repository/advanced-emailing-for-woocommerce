<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;
use rnadvanceemailingwc\Managers\FormulaManager\FRFactory;

class FRCondE extends FRBase
{
    /** @var FRBase */
    public $Cond;
    /** @var FRBase */
    public $Tr;
    /** @var FRBase */
    public $Fa;

    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);

        $this->Cond = FRFactory::GetFRElement($Options->C, $this);
        $this->Tr = FRFactory::GetFRElement($Options->Tr, $this);
        $this->Fa = FRFactory::GetFRElement($Options->Fa, $this);
    }

    public function Parse()
    {
        if ($this->Cond->Parse())
            return $this->Tr->Parse();
        else
            return $this->Fa->Parse();
    }

}