<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\core\Utils\ArrayUtils;
use rnadvanceemailingwc\Managers\FormulaManager\FRBase;
use rnadvanceemailingwc\Managers\FormulaManager\FRFactory;

class FRFCExpression extends FRBase
{
    private $FunctionName;

    /** @var FRBase[] */
    private $Args;


    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);

        $this->FunctionName = $this->Options->Fn;
        $this->Args = [];


        foreach ($this->Options->Ar as $currentItem)
        {
            $this->Args[] = FRFactory::GetFRElement($currentItem, $this);
        }


    }

    public function Parse()
    {

        return $this->GetRetriever()->CallFunction($this->FunctionName, ArrayUtils::Map($this->Args, function ($item) {
            return $item->Parse();
        }));
    }
}