<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;

class FRString extends FRBase
{
    public function Parse()
    {
        return strval($this->Options->d);
    }
}