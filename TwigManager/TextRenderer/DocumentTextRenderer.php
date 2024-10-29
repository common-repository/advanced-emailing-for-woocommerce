<?php

namespace rnadvanceemailingwc\TwigManager\TextRenderer;

use rnadvanceemailingwc\Fields\Core\OrderItem;
use rnadvanceemailingwc\TwigManager\TextRenderer\Core\TextRendererBase;

class DocumentTextRenderer extends TextRendererBase
{
    public $AdditionalOptions=null;
    public function __construct($content, $parent = null,$additionalOptions=null)
    {
        $this->AdditionalOptions=$additionalOptions;

        parent::__construct($content, $parent);
    }

    public function GetAdditionalOptionValue($name,$defaultValue='')
    {
        if($this->AdditionalOptions==null||!isset($this->AdditionalOptions->$name))
            return $defaultValue;

        return $this->AdditionalOptions->$name;
    }

    protected function GetTemplateName()
    {
        return 'TwigManager/TextRenderer/DocumentTextRenderer.twig';
    }

    public static function IsEmpty($content)
    {
        if($content==null)
            return true;

        if(is_array($content))
        {
            foreach($content as $contentItem)
            {
                if(!self::IsEmpty($contentItem))
                    return false;
            }
        }else{
            if($content->type=='text'&&isset($content->text)&&trim($content->text)!='')
                return false;

            if(isset($content->content))
                return self::IsEmpty($content->content);
        }

        return true;
    }
}