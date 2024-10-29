<?php

namespace rnadvanceemailingwc\Fields\ShippingAddress;

use rnadvanceemailingwc\Fields\Core\FieldBase;
use Twig\Markup;

class ShippingLastName  extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetShippingLastName();
    }

    public function InternalToHtml()
    {
        return $this->OrderRetriever->Order->GetShippingLastName();
    }


    public function InternalTestText()
    {
        return "Doe";
    }
}