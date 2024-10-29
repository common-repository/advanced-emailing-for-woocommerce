<?php

namespace rnadvanceemailingwc\Fields\SubTotalFields;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class SubTotalField extends FieldBase
{

    public function InternalToText()
    {
        $totals=$this->OrderRetriever->Order->GetOrderItemTotals();

    }

    public function InternalToHtml()
    {
        $totals=$this->OrderRetriever->Order->GetOrderItemTotals();
        return $totals;
    }

    public function InternalTestText()
    {
        return "1";
    }
}