<?php

namespace rnadvanceemailingwc\Fields;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class OrderStatusField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetStatus();
    }

    public function InternalTestText()
    {
        return 'wc-completed';
    }
}