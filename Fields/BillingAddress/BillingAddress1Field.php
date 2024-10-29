<?php

namespace rnadvanceemailingwc\Fields\BillingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class BillingAddress1Field extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetBillingAddress1();
    }

    public function InternalTestText()
    {
        return "N/A";
    }
}