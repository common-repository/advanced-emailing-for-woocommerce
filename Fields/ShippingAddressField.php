<?php

namespace rnadvanceemailingwc\Fields;

use rnadvanceemailingwc\Fields\Core\FieldBase;
use Twig\Markup;

class ShippingAddressField extends FieldBase
{

    public function InternalToText()
    {
        $order=$this->OrderRetriever->Order;

        return $order->GetShippingAddress1().' '.
            $order->GetShippingAddress2().' '.
            $order->GetShippingCity().' '.
            $order->GetShippingState().' '.
            $order->GetShippingPostalcode().' '.
            $order->GetShippingFirstName().' '.
            $order->GetShippingLastName().' '.
            $order->GetShippingCountry().' '.
            $order->GetShippingPhone();
    }


    public function InternalToHtml()
    {
        $order=$this->OrderRetriever->Order;
        $text='';
        $text=$this->AddField($text,$order->GetShippingFirstName().' '.$order->GetShippingLastName());
        $text=$this->AddField($text,$order->GetShippingAddress1());
        $text=$this->AddField($text,$order->GetShippingAddress2());
        $text=$this->AddField($text,$order->GetShippingCity());
        $text=$this->AddField($text,$order->GetShippingState());
        $text=$this->AddField($text,$order->GetShippingPostalcode());
        $text=$this->AddField($text,$order->GetShippingCountry());
        $text=$this->AddField($text,$order->GetShippingPhone());

        return new Markup($text,'UTF-8');
    }

    public function AddField($text,$textToAdd)
    {
        if(trim($textToAdd==''))
            return $text;
        if($text!='')
            $text.='<br/>';
        $text.=esc_html(trim($textToAdd));
        return $text;
    }
    public function InternalTestText()
    {
        return 'N/A';
    }
}