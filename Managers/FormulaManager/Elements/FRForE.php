<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\FRBase;
use rnadvanceemailingwc\Managers\FormulaManager\FRFactory;
use rnadvanceemailingwc\Managers\FormulaManager\Utilities\FRUtilities;

class FRForE extends FRBase
{
    /** @var FRBase */
    private $Expression;
    private $Value = '';
    private $Key = '';
    /** @var FRBase */
    private $Statement;
    private $ShouldBreak = false;

    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);

        $this->Expression = FRFactory::GetFRElement($Options->E, $this);
        $this->Value = $Options->V;
        $this->Key = $Options->K;
        $this->Statement = FRFactory::GetFRElement($Options->D, $this);
    }

    public function Parse()
    {
        $result = $this->Expression->Parse();

        $keys = [];
        if (is_array($result))
            $keys = array_keys($result);
        else
            foreach ($result as $key => $value)
                $keys[] = $key;

        foreach ($keys as $key)
        {
            $value = $result[$key];

            $this->GetRetriever()->SetVar($this->Value, $value);
            if ($this->Key != '')
                $this->GetRetriever()->SetVar($this->Key, $key);

            $lastResult = $this->Statement->Parse();

            if ($this->ShouldBreak)
                return $lastResult;

        }

    }


    public function ReturnWasExecuted()
    {
        $this->ShouldBreak = true;
        FRUtilities::NotifyReturnToParent($this);
    }

    public function BreakWasExecuted()
    {
        $this->ShouldBreak = true;
    }

}