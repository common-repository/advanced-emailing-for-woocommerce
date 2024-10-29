<?php

namespace rnadvanceemailingwc\Fields\ShippingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class ShippingPostcodeField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetShippingPostalcode();
    }

    public function InternalTestText()
    {
        return 'N/A';
    }
}