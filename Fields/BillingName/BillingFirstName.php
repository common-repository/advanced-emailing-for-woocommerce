<?php

namespace rnadvanceemailingwc\Fields\BillingName;

use rnadvanceemailingwc\Fields\Core\FieldBase;
use Twig\Markup;

class BillingFirstName extends FieldBase
{
    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetBillingFirstName();
    }

    public function InternalToHtml()
    {
        return $this->OrderRetriever->Order->GetBillingFirstName();
    }


    public function InternalTestText()
    {
        return "John";
    }
}