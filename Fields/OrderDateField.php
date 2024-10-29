<?php

namespace rnadvanceemailingwc\Fields;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class OrderDateField extends FieldBase
{

    public function InternalToText()
    {
        if($this->OrderRetriever->Order->GetDateCreated()==null)
            return '';
        return $this->OrderRetriever->Order->GetDateCreated()->format(wc_date_format());
    }

    public function ToNumber()
    {
        if($this->OrderRetriever->Order->GetDateCreated()==null)
            return 0;
        return $this->OrderRetriever->Order->GetDateCreated()->getOffsetTimestamp();
    }

    public function InternalTestText()
    {
        return date('j F, Y');
    }
}