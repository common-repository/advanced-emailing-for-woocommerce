<?php

namespace rnadvanceemailingwc\Fields\BillingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class BillingCompanyField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetBillingCompany();
    }

    public function InternalTestText()
    {
        return 'N/A';
    }
}