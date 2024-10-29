<?php

namespace rnadvanceemailingwc\Fields\ShippingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class ShippingAddress2Field extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetShippingAddress2();
    }

    public function InternalTestText()
    {
        return 'N/A';
    }
}