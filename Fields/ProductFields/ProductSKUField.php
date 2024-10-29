<?php

namespace rnadvanceemailingwc\Fields\ProductFields;

use rnadvanceemailingwc\Fields\Core\FieldBase;
use Twig\Markup;

class ProductSKUField extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->GetCurrentOrderLine()->GetSKU();
    }

    public function InternalToHtml()
    {
        $lineItem=$this->OrderRetriever->GetCurrentOrderLine();
        $html='';
        $html=esc_html($lineItem->GetSKU());

        return new Markup($html,'UTF-8');

    }

    public function InternalTestText()
    {
        return "1";
    }
}