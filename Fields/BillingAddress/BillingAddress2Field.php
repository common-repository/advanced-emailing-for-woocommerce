<?php

namespace rnadvanceemailingwc\Fields\BillingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class BillingAddress2Field extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetBillingAddress2();
    }

    public function InternalTestText()
    {
        return 'N/A';
    }
}