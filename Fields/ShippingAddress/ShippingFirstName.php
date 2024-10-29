<?php

namespace rnadvanceemailingwc\Fields\ShippingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;
use Twig\Markup;

class ShippingFirstName extends FieldBase
{
    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetShippingFirstName();
    }

    public function InternalToHtml()
    {
        return $this->OrderRetriever->Order->GetShippingFirstName();
    }


    public function InternalTestText()
    {
        return "John";
    }
}