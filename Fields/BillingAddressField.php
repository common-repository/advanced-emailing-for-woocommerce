<?php

namespace rnadvanceemailingwc\Fields;

use rnadvanceemailingwc\Fields\Core\FieldBase;
use Twig\Markup;

class BillingAddressField extends FieldBase
{

    public function InternalToText()
    {
        $order=$this->OrderRetriever->Order;

        return $order->GetBillingAddress1().' '.
            $order->GetBillingAddress2().' '.
            $order->GetBillingCity().' '.
            $order->GetBillingState().' '.
            $order->GetBillingPostalcode().' '.
            $order->GetBillingFirstName().' '.
            $order->GetBillingLastName().' '.
            $order->GetBillingEmail().' '.
            $order->GetBillingCountry().' '.
            $order->GetBillingPhone();
    }

    public function InternalToHtml()
    {
        return new Markup($this->OrderRetriever->Order->GetFormattedBillingAddress(),'UTF-8');
    }

    public function InternalTestText()
    {
        return 'N/A';
    }
}