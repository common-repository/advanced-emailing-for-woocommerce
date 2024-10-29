<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;
use rnadvanceemailingwc\Managers\FormulaManager\FRFactory;

class FRUnaryExpression extends FRBase
{
    private $Subtype;
    /** @var FRBase */
    private $Expression;

    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);
        $this->Subtype = $Options->St;
        $this->Expression = FRFactory::GetFRElement($this->Options->d, $this);
    }

    public function Parse()
    {
        return !$this->Expression->Parse();
    }

}