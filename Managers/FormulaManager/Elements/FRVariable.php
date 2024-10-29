<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;

class FRVariable extends FRBase
{
    public $Name;

    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);
        $this->Name = $this->Options->d;
    }

    public function &Parse()
    {
        return $this->GetRetriever()->GetVar($this->Name);
    }

    /**
     * @param $Value FRBase
     * @return void
     */
    public function Assign($Value)
    {
        $this->GetRetriever()->SetVar($this->Name, $Value);
    }

}