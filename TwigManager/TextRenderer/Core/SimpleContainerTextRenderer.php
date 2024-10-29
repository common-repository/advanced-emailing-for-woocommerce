<?php

namespace rnadvanceemailingwc\TwigManager\TextRenderer\Core;

use Twig\Markup;

class SimpleContainerTextRenderer extends TextRendererBase
{
    public $TagToUse;
    public function __construct($tagToUse,$content, $parent = null)
    {
        $this->TagToUse=$tagToUse;
        parent::__construct($content, $parent);
    }


    protected function GetTemplateName()
    {
        return 'TwigManager/TextRenderer/Core/SimpleContainerTextRenderer.twig';
    }

    public function GetAlignment(){
        switch ($this->Content->attrs->align)
        {
            case 'left':
                return 'left';
            case 'right':
                return 'right';
            case 'center':
                return 'center';
            default:
                return 'left';
        }
    }

    protected function InternalInitialize()
    {
        parent::InternalInitialize(); // TODO: Change the autogenerated stub
    }


    /**
     * @return mixed
     */
    public function getContent()
    {
        if($this->TagToUse=='p'&&count($this->Children)==0)
            return new Markup('<br/>','UTF-8');
        return $this->RenderChildren();
    }


}