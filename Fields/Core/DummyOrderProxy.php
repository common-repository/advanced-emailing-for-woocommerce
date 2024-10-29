<?php

namespace rnadvanceemailingwc\Fields\Core;

class DummyOrderProxy extends OrderProxy
{

    public function __construct()
    {
        parent::__construct(null);
    }

    public function GetBillingAddress1(){
        return 'Billing Address 1';
    }
}