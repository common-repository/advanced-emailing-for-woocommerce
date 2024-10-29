<?php

namespace rnadvanceemailingwc\Fields\ShippingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class ShippingStateField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetShippingState();
    }

    public function InternalTestText()
    {
        return 'N/A';
    }
}