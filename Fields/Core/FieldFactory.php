<?php

namespace rnadvanceemailingwc\Fields\Core;

use rnadvanceemailingwc\Fields\BillingAddress\BillingAddress1Field;
use rnadvanceemailingwc\Fields\BillingAddress\BillingAddress2Field;
use rnadvanceemailingwc\Fields\BillingAddress\BillingCityField;
use rnadvanceemailingwc\Fields\BillingAddress\BillingCountryField;
use rnadvanceemailingwc\Fields\BillingAddress\BillingEmailField;
use rnadvanceemailingwc\Fields\BillingAddress\BillingPhoneField;
use rnadvanceemailingwc\Fields\BillingAddress\BillingPostcodeField;
use rnadvanceemailingwc\Fields\BillingAddress\BillingStateField;
use rnadvanceemailingwc\Fields\BillingAddressField;
use rnadvanceemailingwc\Fields\BillingName\BillingFirstName;
use rnadvanceemailingwc\Fields\BillingName\BillingLastName;
use rnadvanceemailingwc\Fields\BillingNameField;
use rnadvanceemailingwc\Fields\CustomerFields\CustomerEmailField;
use rnadvanceemailingwc\Fields\OrderDateField;
use rnadvanceemailingwc\Fields\OrderNumberField;
use rnadvanceemailingwc\Fields\OrderStatusField;
use rnadvanceemailingwc\Fields\ProductFields\ProductNameAndQuantityField;
use rnadvanceemailingwc\Fields\ProductFields\ProductNameField;
use rnadvanceemailingwc\Fields\ProductFields\ProductPriceField;
use rnadvanceemailingwc\Fields\ProductFields\ProductQuantityField;
use rnadvanceemailingwc\Fields\ShippingAddress\ShippingAddress1Field;
use rnadvanceemailingwc\Fields\ShippingAddress\ShippingAddress2Field;
use rnadvanceemailingwc\Fields\ShippingAddress\ShippingCityField;
use rnadvanceemailingwc\Fields\ShippingAddress\ShippingCountryField;
use rnadvanceemailingwc\Fields\ShippingAddress\ShippingFirstName;
use rnadvanceemailingwc\Fields\ShippingAddress\ShippingLastName;
use rnadvanceemailingwc\Fields\ShippingAddress\ShippingNameField;
use rnadvanceemailingwc\Fields\ShippingAddress\ShippingPhoneField;
use rnadvanceemailingwc\Fields\ShippingAddress\ShippingPostcodeField;
use rnadvanceemailingwc\Fields\ShippingAddress\ShippingStateField;
use rnadvanceemailingwc\Fields\ShippingAddressField;
use rnadvanceemailingwc\Fields\SubTotalFields\ShippingTotalField;
use rnadvanceemailingwc\Fields\SubTotalFields\SubTotalField;
use rnadvanceemailingwc\Fields\SubTotalFields\SubTotalValueField;


class FieldFactory
{
    public static function GetField($id,$options,$orderRetriever,$parent=null)
    {
        switch ($id)
        {
            case 'CustomerEmail':
                return new CustomerEmailField($options,$orderRetriever,$parent);
            case 'OrderStatus':
                return new OrderStatusField($options,$orderRetriever,$parent);
            case 'OrderNumber':
                return new OrderNumberField($options,$orderRetriever,$parent);
            case 'BillingFirstName':
                return new BillingFirstName($options,$orderRetriever,$parent);
            case 'BillingLastName':
                return new BillingLastName($options,$orderRetriever,$parent);
            case 'BillingName':
                return new BillingNameField($options,$orderRetriever,$parent);
            case 'BillingAddress1':
                return new BillingAddress1Field($options,$orderRetriever,$parent);
            case 'BillingAddress2':
                return new BillingAddress2Field($options,$orderRetriever,$parent);
            case 'BillingCity':
                return new BillingCityField($options,$orderRetriever,$parent);
            case 'BillingPostcode':
                return new BillingPostcodeField($options,$orderRetriever,$parent);
            case 'BillingCountry':
                return new BillingCountryField($options,$orderRetriever,$parent);
            case 'BillingState':
                return new BillingStateField($options,$orderRetriever,$parent);
            case 'BillingEmail':
                return new BillingEmailField($options,$orderRetriever,$parent);
            case 'BillingPhone':
                return new BillingPhoneField($options,$orderRetriever,$parent);
            case 'OrderDate':
                return new OrderDateField($options,$orderRetriever,$parent);
            case 'BillingAddress':
                return new BillingAddressField($options,$orderRetriever,$parent);
            case 'ShippingAddress':
                return new ShippingAddressField($options,$orderRetriever,$parent);
            case 'ProductName':
                return new ProductNameField($options,$orderRetriever,$parent);
            case 'ProductQuantity':
                return new ProductQuantityField($options,$orderRetriever,$parent);
            case 'ProductSKU':
                return new ProductQuantityField($options,$orderRetriever,$parent);
            case 'ProductPrice':
                return new ProductPriceField($options,$orderRetriever,$parent);
            case 'SubTotal':
                return new SubTotalField($options,$orderRetriever,$parent);
            case 'ShippingTotal':
                return new ShippingTotalField($options,$orderRetriever,$parent);
            case 'SubtotalValue':
                return new SubTotalValueField($options,$orderRetriever,$parent);
            case 'ProductNameQuantity':
                return new ProductNameAndQuantityField($options,$orderRetriever,$parent);
            case 'ShippingFirstName':
                return new ShippingFirstName($options,$orderRetriever,$parent);
            case 'ShippingLastName':
                return new ShippingLastName($options,$orderRetriever,$parent);
            case 'ShippingName':
                return new ShippingNameField($options,$orderRetriever,$parent);
            case 'ShippingAddress1':
                return new ShippingAddress1Field($options,$orderRetriever,$parent);
            case 'ShippingAddress2':
                return new ShippingAddress2Field($options,$orderRetriever,$parent);
            case 'ShippingCity':
                return new ShippingCityField($options,$orderRetriever,$parent);
            case 'ShippingPostcode':
                return new ShippingPostcodeField($options,$orderRetriever,$parent);
            case 'ShippingCountry':
                return new ShippingCountryField($options,$orderRetriever,$parent);
            case 'ShippingState':
                return new ShippingStateField($options,$orderRetriever,$parent);
            case 'ShippingPhone':
                return new ShippingPhoneField($options,$orderRetriever,$parent);
            default:
                throw new \Exception('Undefined field '.$id);
        }
    }

}