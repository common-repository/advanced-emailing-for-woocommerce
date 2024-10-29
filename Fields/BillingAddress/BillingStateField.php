<?php

namespace rnadvanceemailingwc\Fields\BillingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class BillingStateField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetBillingState();
    }

    public function InternalTestText()
    {
        return 'N/A';
    }
}