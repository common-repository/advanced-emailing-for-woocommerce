<?php

namespace rnadvanceemailingwc\Fields\BillingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class BillingCountryField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetBillingCountry();
    }

    public function InternalTestText()
    {
        return 'N/A';
    }
}