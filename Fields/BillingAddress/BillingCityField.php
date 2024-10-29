<?php

namespace rnadvanceemailingwc\Fields\BillingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class BillingCityField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetBillingCity();
    }

    public function InternalTestText()
    {
        return 'N/A';
    }
}