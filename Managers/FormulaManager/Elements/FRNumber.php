<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;

class FRNumber extends FRBase
{
    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);
    }

    public function Parse()
    {
        $value = strval($this->Options->d);
        if (!is_numeric($value))
            throw new \Exception('Invalid number ' . $value);

        return floatval($value);
    }
}