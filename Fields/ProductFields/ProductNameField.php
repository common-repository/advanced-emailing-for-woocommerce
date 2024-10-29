<?php

namespace rnadvanceemailingwc\Fields\ProductFields;

use rnadvanceemailingwc\Fields\Core\FieldBase;
use Twig\Markup;

class ProductNameField extends FieldBase
{

    public function InternalToText()
    {
        $line=$this->OrderRetriever->GetCurrentOrderLine();
        return $line->GetName();
    }

    public function InternalToHtml()
    {

        $showThumbnail=$this->GetOptionsAttribute('ShowThumbnail');
        $lineItem=$this->OrderRetriever->GetCurrentOrderLine();

        if($showThumbnail=='1')
        {
            $product = $lineItem->GetProduct();
            $text = '';
            if ($product != null)
            {

                $image = $product->get_image([64, 64]);
                $text = '<div style="margin-right: 5px;display: inline-block;vertical-align: middle">' . $image . '</div>';
            }
        }
        $text.='<div style="display:inline-block;vertical-align: middle">'.esc_html($lineItem->GetName());



        $hidden_order_itemmeta = apply_filters(
            'woocommerce_hidden_order_itemmeta',
            array(
                '_qty',
                '_tax_class',
                '_product_id',
                '_variation_id',
                '_line_subtotal',
                '_line_subtotal_tax',
                '_line_total',
                '_line_tax',
                'method_id',
                'cost',
                '_reduced_stock',
                '_restock_refunded_items',
            )
        );
        $metaData=$lineItem->GetFormattedMetadata();

        $text.='<ul class="wc-item-meta">';

        foreach($metaData as $metaId=>$meta)
        {
            if ( in_array( $meta->key, $hidden_order_itemmeta, true ) ) {
                continue;
            }

            $text.='<li style="margin: 0.5em 0 0; padding: 0;">';
            $text.='<strong style="float:left;margin-right: .25em;">'.wp_kses_post($meta->display_key).':</strong>';
            $text.='<span>'.wp_kses_post($meta->display_value).'</span>';
            $text.='</li>';

        }
        $text.='</ul>';
        $text.='</div>';

        return new Markup($text,'UTF-8');

    }

    public function InternalTestText()
    {
        return "My awesome product";
    }
}