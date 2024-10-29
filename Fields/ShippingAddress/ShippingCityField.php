<?php

namespace rnadvanceemailingwc\Fields\ShippingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class ShippingCityField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetShippingCity();
    }

    public function InternalTestText()
    {
        return 'N/A';
    }
}