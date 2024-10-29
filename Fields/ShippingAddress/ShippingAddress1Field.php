<?php

namespace rnadvanceemailingwc\Fields\ShippingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class ShippingAddress1Field extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetShippingAddress1();
    }

    public function InternalTestText()
    {
        return "N/A";
    }
}