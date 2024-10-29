<?php

namespace rnadvanceemailingwc\TwigManager\Renderers;

use rnadvanceemailingwc\DTO\RowOptionsDTO;
use rnadvanceemailingwc\DTO\SectionOptionsDTO;
use rnadvanceemailingwc\TwigManager\Renderers\Core\ISectionContainer;
use rnadvanceemailingwc\TwigManager\Renderers\Core\RendererBase;

class SectionRenderer extends RendererBase
{
    /** @var ISectionContainer */
    public $Parent;
    /** @var SectionOptionsDTO */
    public $Options;
    /** @var RowRenderer[] */
    public $Rows;

    public function __construct($options, $parent = null)
    {
        parent::__construct($options, $parent);
        $this->Rows=[];
        foreach($this->Options->Rows as $currentRow)
        {
            $this->Rows[]=new RowRenderer($currentRow,$this);
        }
    }

    public function GetUniqueId(){
        return 'Section_'.$this->Options->Id;
    }



    public function IsEmpty(){
        foreach($this->Rows as $currentRow)
            if(!$currentRow->IsEmpty())
                return false;
        return true;
    }
    protected function GetTemplateName()
    {
        return 'TwigManager/Renderers/SectionRenderer.twig';
    }

    protected function InternalInitialize()
    {
        foreach ($this->Rows as $row)
            $row->Initialize();
    }

    public function GetChildren()
    {
        return $this->Rows;
    }
}