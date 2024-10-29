<?php

namespace rnadvanceemailingwc\Fields\Test;

use rnadvanceemailingwc\Fields\Core\DummyOrderProxy;
use rnadvanceemailingwc\Fields\Core\OrderItem;
use rnadvanceemailingwc\Fields\Core\OrderRetriever;

class TestOrderRetriever extends OrderRetriever
{
    public $IsTest=true;
    public $Order;

    public function __construct($loader, $order = null)
    {
        parent::__construct($loader, $order);

        $this->CreateFakeOrder();
    }



    public function GetOrderURL()
    {
        return '#';
    }

    private function CreateFakeOrder()
    {
        $this->RealOrder=new TestOrderWrapper();

        $productOrderItem=new \WC_Order_Item_Product();
        $this->RealOrder->add_item($productOrderItem);
        $this->Order=$this->CreateProxy();

    }

}