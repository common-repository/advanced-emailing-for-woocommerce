<?php

namespace rnadvanceemailingwc\Fields\ShippingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;
use Twig\Markup;

class ShippingNameField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetBillingFirstName().' '.$this->OrderRetriever->Order->GetBillingLastName();
    }

    public function InternalToHtml()
    {
        return new Markup($this->OrderRetriever->Order->GetFormattedBillingFullName(),'UTF-8');
    }


    public function InternalTestText()
    {
        return "John Doe";
    }
}