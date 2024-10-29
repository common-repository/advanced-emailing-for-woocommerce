<?php

namespace rnadvanceemailingwc\Fields\ProductFields;

use rnadvanceemailingwc\Fields\Core\FieldBase;
use Twig\Markup;
use function wc_price;

class ProductPriceField extends FieldBase
{

    public function InternalToText()
    {
        $lineItem=$this->OrderRetriever->GetCurrentOrderLine();
        return $this->OrderRetriever->Order->GetLineSubTotal($lineItem);
    }

    public function InternalToHtml()
    {
        $lineItem=$this->OrderRetriever->GetCurrentOrderLine();
        return new Markup($this->OrderRetriever->Order->GetFormattedLineSubTotal($lineItem),'UTF-8');
    }

    public function InternalTestText()
    {
        return 10;
    }

    public function InternalTestHTML()
    {
        return new Markup(wc_price(10),'UTF-8');
    }
}