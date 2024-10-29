<?php
namespace rnadvanceemailingwc\TwigManager\TextRenderer;

use rnadvanceemailingwc\TwigManager\TextRenderer\Core\TextRendererBase;

class RawTextRenderer extends TextRendererBase{

    public function __construct($tagToUse,$content, $parent = null)
    {
        $this->TagToUse=$tagToUse;
        parent::__construct($content, $parent);
    }

    protected function GetTemplateName()
    {
        return '';
    }

    public function Render()
    {
        return $this->TagToUse;
    }


}