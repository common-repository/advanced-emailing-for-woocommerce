<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;

class FRNull extends FRBase
{
    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);
    }

    public function Parse()
    {
        return null;
    }


}