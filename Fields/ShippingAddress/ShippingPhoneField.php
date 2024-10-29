<?php

namespace rnadvanceemailingwc\Fields\ShippingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class ShippingPhoneField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetShippingPhone();
    }

    public function InternalTestText()
    {
        return 0;
    }
}