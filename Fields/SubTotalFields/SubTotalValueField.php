<?php

namespace rnadvanceemailingwc\Fields\SubTotalFields;

use rnadvanceemailingwc\Fields\Core\FieldBase;
use rnadvanceemailingwc\TwigManager\TextRenderer\DocumentTextRenderer;
use rnadvanceemailingwc\Utilities\TreeSeeker\TreeSeeker;
use Twig\Markup;
use function wc_price;

class SubTotalValueField extends FieldBase
{

    public function InternalToText()
    {
        return '';
    }


    public function InternalToHtml()
    {
        /** @var DocumentTextRenderer $parent */
        $parent=TreeSeeker::GetParentOfType($this,DocumentTextRenderer::class);
        if($parent==null||$parent->GetAdditionalOptionValue('SubTotalValue')=='')
            return '';

        return new Markup($parent->GetAdditionalOptionValue('SubTotalValue'),'UTF-8');
    }


    public function InternalTestText()
    {
        $type=$this->OrderRetriever->GetMeta('SubTotalType');
        switch ($type)
        {
            case 'Subtotal':
                return "10";
            case 'Shipping':
                return "5";
            case 'Tax':
                return "1.5";
            case 'PaymentMethod':
                return __('Credit Card');
            case 'Total':
                return "16.5";
        }
        return $type;
    }

    public function InternalTestHTML()
    {
        $type=$this->OrderRetriever->GetMeta('SubTotalType');
        switch ($type)
        {
            case 'Subtotal':
                return new Markup(wc_price("10"),'UTF-8');
            case 'Shipping':
                return new Markup(wc_price("5").' via Standard','UTF-8');
            case 'Tax':
                return new Markup(wc_price("1.5"),'UTF-8');
            case 'PaymentMethod':
                return __('Credit Card');
            case 'Total':
                return new Markup(wc_price("16.5"),'UTF-8');
        }
        return $type;
    }
}