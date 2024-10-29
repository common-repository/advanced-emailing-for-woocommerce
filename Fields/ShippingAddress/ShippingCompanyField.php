<?php

namespace rnadvanceemailingwc\Fields\ShippingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class ShippingCompanyField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetShippingCompany();
    }

    public function InternalTestText()
    {
        return 'N/A';
    }
}