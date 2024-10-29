<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;
use rnadvanceemailingwc\Managers\FormulaManager\FRFactory;

class FRArray extends FRBase
{
    /** @var FRBase[] */
    public $Items = [];

    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);
        $this->Items = [];

        foreach ($Options->d as $item)
        {
            $this->Items[] = FRFactory::GetFRElement($item, $this);
        }


    }

    public function &Parse()
    {
        $items = [];
        foreach ($this->Items as $x)
        {
            $items[] = $x->Parse();
        }

        return $items;
    }
}