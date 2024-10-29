<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;
use rnadvanceemailingwc\Managers\FormulaManager\FRFactory;
use rnadvanceemailingwc\Managers\FormulaManager\Utilities\FRUtilities;

class FRReturn extends FRBase
{
    /** @var FRBase */
    public $Statement;

    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);
        $this->Statement = FRFactory::GetFRElement($Options->d, $this);
    }

    public function Parse()
    {
        FRUtilities::NotifyReturnToParent($this);
        return $this->Statement->Parse();
    }
}