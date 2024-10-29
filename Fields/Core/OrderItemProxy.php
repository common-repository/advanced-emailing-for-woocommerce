<?php

namespace rnadvanceemailingwc\Fields\Core;

class OrderItemProxy
{
    /** @var OrderProxy */
    public $Order;
    /** @var \WC_Order_Item_Product */
    public $Item;
    public function __construct($order,$item)
    {
        $this->Order=$order;
        $this->Item=$item;
    }

    public function GetId(){
        return $this->Item->get_id();
    }

    public function GetName(){
        return $this->Item->get_name();
    }

    /**
     * @return \WC_Product
     */
    public function GetProduct()
    {
        if(method_exists($this->Item,'get_product'))
            return $this->Item->get_product();
        return null;
    }
    public function GetQuantity(){
        return $this->Item->get_quantity();
    }

    public function GetSKU(){
        $product= $this->Item->get_product();
        if($product!=null)
            $product->get_sku();

        return '';
    }
    public function GetMeta($key)
    {
        return $this->Item->get_meta($key);
    }

    public function GetFormattedMetadata(){
        return $this->Item->get_formatted_meta_data();
    }

}