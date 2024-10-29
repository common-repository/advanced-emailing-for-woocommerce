<?php

namespace rnadvanceemailingwc\TwigManager\Renderers;

use rnadvanceemailingwc\DTO\ColumnOptionsDTO;
use rnadvanceemailingwc\TwigManager\Renderers\Blocks\Core\BlockRendererBase;
use rnadvanceemailingwc\TwigManager\Renderers\Blocks\Core\BlockRendererFactory;
use rnadvanceemailingwc\TwigManager\Renderers\Core\IRowContainer;
use rnadvanceemailingwc\TwigManager\Renderers\Core\RendererBase;

class ColumnRenderer extends RendererBase
{
    /** @var RowRenderer */
    public $Parent;
    /** @var ColumnOptionsDTO */
    public $Options;
    /** @var BlockRendererBase[] */
    public $Blocks;
    public $Align;

    public function __construct($options, $parent = null)
    {
        $this->Blocks=[];
        parent::__construct($options, $parent);
        foreach($this->Options->Blocks as $blockOptions)
        {
            $this->Blocks[]=BlockRendererFactory::GetBlockRenderer($blockOptions,$this);
        }

    }

    public function IsEmpty(){
        foreach($this->Blocks as $currentBlock)
            if(!$currentBlock->IsEmpty())
                return false;
        return true;
    }

    public function GetUniqueId(){
        return 'Column_'.$this->Options->Id;
    }


    public function GetWidth()
    {
        return $this->Options->WidthPercentage;

    }
    protected function GetTemplateName()
    {
        return 'TwigManager/Renderers/ColumnRenderer.twig';
    }

    protected function InternalInitialize()
    {
        $this->Align=$this->Options->Align;
        if($this->Align=='center')
            $this->Align='middle';
        foreach($this->Blocks as $currentBlock)
            $currentBlock->Initialize();
    }

    public function GetChildren()
    {
        return $this->Blocks;
    }


}