<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;
use rnadvanceemailingwc\Managers\FormulaManager\FRFactory;

class FRAssigmentExpression extends FRBase
{
    /** @var FRBase */
    private $Asignee;
    /** @var FRBase */
    private $Value;

    public function __construct($Options, $Parent)
    {

        parent::__construct($Options, $Parent);

        $this->Asignee = FRFactory::GetFRElement($this->Options->As, $this);
        $this->Value = FRFactory::GetFRElement($this->Options->D, $this);
    }

    public function Parse()
    {
        $value = $this->Value->Parse();
        if ($this->Asignee->GetType() == 'VAR')
            $this->Asignee->Assign($value);
        else
        {
            $this->Asignee->Assign($value);
        }
    }

}