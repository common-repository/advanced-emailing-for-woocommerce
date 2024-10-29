<?php

namespace rnadvanceemailingwc\Fields\CustomerFields;

use rnadvanceemailingwc\Fields\Core\FieldBase;

class CustomerEmailField extends FieldBase
{

    public function InternalToText()
    {
        $user= $this->OrderRetriever->Order->GetUser();
        if($user==null)
            return '';

        return $user->user_email;

    }

    public function InternalTestText()
    {
        return 'customer@email.com';
    }
}