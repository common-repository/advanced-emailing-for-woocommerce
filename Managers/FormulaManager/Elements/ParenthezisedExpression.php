<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;
use rnadvanceemailingwc\Managers\FormulaManager\FRFactory;

class ParenthezisedExpression extends FRBase
{
    /** @var FRBase */
    public $Sentence;

    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);
        $this->Sentence = FRFactory::GetFRElement($this->Options->d, $this);
    }

    public function Parse()
    {
        return $this->Sentence->Parse();
    }

}