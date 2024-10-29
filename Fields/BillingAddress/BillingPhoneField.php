<?php

namespace rnadvanceemailingwc\Fields\BillingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class BillingPhoneField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetBillingPhone();
    }

    public function InternalTestText()
    {
        return 0;
    }
}