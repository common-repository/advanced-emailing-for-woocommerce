<?php

namespace rnadvanceemailingwc\TwigManager\TextRenderer;

use rnadvanceemailingwc\Fields\Core\FieldBase;
use rnadvanceemailingwc\Fields\Core\FieldFactory;
use rnadvanceemailingwc\TwigManager\TextRenderer\Core\TextRendererBase;

class FieldTextRenderer extends TextTextRenderer
{
    /** @var FieldBase */
    public $Field;

    public function GetText()
    {
        $fieldId=$this->Content->attrs->id;
        $fieldOptions=null;
        if(isset($this->Content->attrs->options))
            $fieldOptions=$this->Content->attrs->options;

        if(isset($this->Content->attrs->type)&&$this->Content->attrs->type=='CustomField')
        {
            $this->Field=$this->Parent->GetEmailRenderer()->GetCustomField($fieldId,$fieldOptions,$this->Parent->GetEmailRenderer()->OrderRetriever,$this);
        }else
            $this->Field=FieldFactory::GetField($fieldId,$fieldOptions,$this->Parent->GetEmailRenderer()->OrderRetriever,$this);

        if($this->Field!=null)
        {
            return $this->Field->ToHTML();
        }

        return '';
    }


}