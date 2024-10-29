<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;
use rnadvanceemailingwc\Managers\FormulaManager\Utilities\FRUtilities;

class FRBreak extends FRBase
{
    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);
    }

    public function Parse()
    {
        FRUtilities::NotifyBreakToParent($this);
    }
}