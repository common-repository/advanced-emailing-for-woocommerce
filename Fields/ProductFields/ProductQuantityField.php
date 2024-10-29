<?php

namespace rnadvanceemailingwc\Fields\ProductFields;

use rnadvanceemailingwc\Fields\Core\FieldBase;
use Twig\Markup;

class ProductQuantityField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->GetCurrentOrderLine()->GetQuantity();
    }

    public function InternalToHtml()
    {
        $lineItem=$this->OrderRetriever->GetCurrentOrderLine();
        $html='';
        $qty=$lineItem->GetQuantity();
        $refunded_qty=$this->OrderRetriever->Order->GetQtyRefundedForItem($lineItem->GetId());

        if($refunded_qty)
        {
            $html= '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>';
        }else{
            $html=esc_html($qty);
        }

        return new Markup($html,'UTF-8');

    }

    public function InternalTestText()
    {
        return "1";
    }
}