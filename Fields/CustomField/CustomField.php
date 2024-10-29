<?php

namespace rnadvanceemailingwc\Fields\CustomField;

use rnadvanceemailingwc\Fields\Core\FieldBase;
use rnadvanceemailingwc\Managers\FormulaManager\FRMain;
use rnadvanceemailingwc\Utilities\Sanitizer;

class CustomField extends FieldBase
{
    public $CustomField;
    public function __construct($options, $orderRetriever, $parent = null,$customField=null)
    {
        parent::__construct($options, $orderRetriever, $parent);
        $this->CustomField=$customField;
    }

    public function InternalToText()
    {
        return $this->ParseFormula();
    }

    public function InternalTestText()
    {
        return $this->ParseFormula();
    }

    public function InternalTestHTML()
    {
        return $this->ParseFormula();
    }

    public function InternalToHtml()
    {
        return $this->ParseFormula();
    }

    private function ParseFormula()
    {
        $code=Sanitizer::GetValueFromPath($this->CustomField,["CompiledCode"]);
        if($code==null)
            return '';

        $parser=new FRMain($code,$this->OrderRetriever);
        return $parser->Parse();
    }


}