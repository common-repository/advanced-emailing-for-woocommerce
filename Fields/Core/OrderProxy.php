<?php

namespace rnadvanceemailingwc\Fields\Core;

class OrderProxy
{
    /** @var \WC_Order */
    private $Order;
    /** @var OrderItemProxy[] */
    private $Items=null;
    public function __construct($order)
    {
        $this->Order=$order;
    }

    public function GetBillingAddress1(){
        if($this->Order==null)
            return '';
        return $this->Order->get_billing_address_1();
    }

    public function GetBillingAddress2(){
        if($this->Order==null)
            return '';
        return $this->Order->get_billing_address_2();
    }

    /**
     * @param $item OrderItemProxy
     */
    private function GetWCItemByProxy($item){
        if($this->Order==null)
            return [];
        foreach($this->Order->get_items() as $currentItem)
            if($currentItem->get_id()==$item->GetId())
                return $currentItem;

        return null;
    }

    public function GetLineSubTotal($lineItem){
        if($this->Order==null)
            return '';
        return $this->Order->get_line_subtotal($this->GetWCItemByProxy($lineItem));
    }

    public function GetQtyRefundedForItem($itemId)
    {
        if($this->Order==null)
            return '';
        return $this->Order->get_qty_refunded_for_item($itemId);
    }

    public function GetFormattedLineSubTotal($lineItem){
        if($this->Order==null)
            return '';
        return $this->Order->get_formatted_line_subtotal($this->GetWCItemByProxy($lineItem));
    }

    public function GetStatus(){
        if($this->Order==null)
            return '';
        return $this->Order->get_status();
    }
    public function GetBillingFirstName(){
        if($this->Order==null)
            return '';
        return $this->Order->get_billing_first_name();
    }

    public function GetBillingLastName(){
        if($this->Order==null)
            return '';
        return $this->Order->get_billing_last_name();
    }


    public function GetUser(){
        if($this->Order==null)
            return '';
        return $this->Order->get_user();
    }

    public function GetBillingCompany(){
        if($this->Order==null)
            return '';
        return $this->Order->get_billing_company();
    }

    public function GetBillingCity(){
        if($this->Order==null)
            return '';
        return $this->Order->get_billing_city();
    }

    public function GetBillingState(){
        if($this->Order==null)
            return '';
        return $this->Order->get_billing_state();
    }

    public function GetBillingPostalcode(){
        if($this->Order==null)
            return '';
        return $this->Order->get_billing_postcode();
    }

    public function GetBillingCountry(){
        if($this->Order==null)
            return '';
        return $this->Order->get_billing_country();
    }

    public function GetBillingEmail(){
        if($this->Order==null)
            return '';
        return $this->Order->get_billing_email();
    }

    public function GetBillingPhone(){
        if($this->Order==null)
            return '';
        return $this->Order->get_billing_phone();
    }


    public function GetShippingAddress1(){
        if($this->Order==null)
            return '';
        return $this->Order->get_shipping_address_1();
    }

    public function GetShippingAddress2(){
        if($this->Order==null)
            return '';
        return $this->Order->get_shipping_address_2();
    }

    public function GetShippingFirstName(){
        if($this->Order==null)
            return '';
        return $this->Order->get_shipping_first_name();
    }

    public function GetShippingLastName(){
        if($this->Order==null)
            return '';
        return $this->Order->get_shipping_last_name();
    }

    public function GetShippingCompany(){
        if($this->Order==null)
            return '';
        return $this->Order->get_shipping_company();
    }

    public function GetShippingCity(){
        if($this->Order==null)
            return '';
        return $this->Order->get_shipping_city();
    }

    public function GetShippingState(){
        if($this->Order==null)
            return '';
        return $this->Order->get_shipping_state();
    }

    public function GetShippingPostalcode(){
        if($this->Order==null)
            return '';
        return $this->Order->get_shipping_postcode();
    }

    public function GetShippingCountry(){
        if($this->Order==null)
            return '';
        return $this->Order->get_shipping_country();
    }

    public function GetShippingPhone(){
        if($this->Order==null)
            return '';
        if(method_exists($this->Order,'get_shipping_phone'))
            return $this->Order->get_shipping_phone();
        return '';
    }

    public function GetPaymentMethod(){
        if($this->Order==null)
            return '';
        return $this->Order->get_payment_method();
    }

    public function GetPaymentMethodTitle(){
        if($this->Order==null)
            return '';
        return $this->Order->get_payment_method_title();
    }

    public function GetCustomerIpAddress(){
        if($this->Order==null)
            return '';
        return $this->Order->get_customer_ip_address();
    }

    public function GetCustomerNotes(){
        if($this->Order==null)
            return '';
        return $this->Order->get_customer_note();
    }

    public function GetDateCompleted(){
        if($this->Order==null)
            return '';
        return $this->Order->get_date_completed()->format('c');
    }

    public function GetCheckoutPageUrl(){
        if($this->Order==null)
            return '';
        return $this->Order->get_checkout_payment_url();
    }

    public function GetCheckoutOrderReceivedURL(){
        if($this->Order==null)
            return '';
        return $this->Order->get_checkout_order_received_url();
    }

    public function GetCheckoutOrderCancelURL(){
        if($this->Order==null)
            return '';
        return $this->Order->get_cancel_order_url();
    }

    public function GetViewOrderURL(){
        if($this->Order==null)
            return '';
        return $this->Order->get_view_order_url();
    }

    public function GetCustomerOrderNotes(){
        if($this->Order==null)
            return '';
        return $this->Order->get_customer_order_notes();
    }

    public function GetId(){
        if($this->Order==null)
            return '';
        return $this->Order->get_id();
    }

    public function GetMeta($key)
    {
        if($this->Order==null)
            return '';
        $this->Order->get_meta($key);
    }

    public function GetOrderTotal(){
        if($this->Order==null)
            return '';
        return $this->Order->get_formatted_order_total();
    }


    public function GetCustomerId(){
        if($this->Order==null)
            return '';
        return $this->Order->get_customer_id();
    }

    public function GetItems(){
        if($this->Order==null)
            return [];
        if($this->Items==null)
        {
            $this->Items=[];
            foreach($this->Order->get_items() as $currentItem)
            {
                $this->Items[]=new OrderItemProxy($this,$currentItem);
            }

        }

        return $this->Items;

    }

    public function GetOrderNumber(){
        if($this->Order==null)
            return '';
        return $this->Order->get_order_number();
    }
    public function GetFormattedBillingFullName(){
        if($this->Order==null)
            return '';
        return $this->Order->get_formatted_billing_full_name();
    }
    public function GetFormattedBillingAddress(){
        if($this->Order==null)
            return '';
        return $this->Order->get_formatted_billing_address();
    }

    public function GetDateCreated(){
        if($this->Order==null)
            return '';
        return $this->Order->get_date_created();
    }

    public function GetTaxTotals(){
        if($this->Order==null)
            return '';
        return $this->Order->get_tax_totals();
    }

    public function GetCurrency(){
        if($this->Order==null)
            return '';
        return $this->Order->get_currency();
    }
    public function GetItem($index){
        if($this->Order==null)
            return null;
        foreach ($this->GetItems() as $item)
        {
            if($item->GetId()==$index)
                return $item;
        }

        return null;
    }

    public function GetOrderItemTotals(){
        if($this->Order==null)
            return '';
        return $this->Order->get_order_item_totals();
    }

}