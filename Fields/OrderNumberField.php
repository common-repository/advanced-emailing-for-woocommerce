<?php

namespace rnadvanceemailingwc\Fields;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class OrderNumberField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetOrderNumber();
    }

    public function InternalTestText()
    {
        return '1234';
    }
}