<?php

namespace rnadvanceemailingwc\Fields\BillingName;

use rnadvanceemailingwc\Fields\Core\FieldBase;
use Twig\Markup;

class BillingLastName  extends FieldBase
{

    public function InternalToText()
    {
        return $this->OrderRetriever->Order->GetBillingLastName();
    }

    public function InternalToHtml()
    {
        return $this->OrderRetriever->Order->GetBillingLastName();
    }


    public function InternalTestText()
    {
        return "Doe";
    }
}