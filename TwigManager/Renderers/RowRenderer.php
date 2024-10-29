<?php

namespace rnadvanceemailingwc\TwigManager\Renderers;

use rnadvanceemailingwc\DTO\RowOptionsDTO;
use rnadvanceemailingwc\TwigManager\Renderers\Core\IRowContainer;
use rnadvanceemailingwc\TwigManager\Renderers\Core\RendererBase;

class RowRenderer extends RendererBase
{
    /** @var IRowContainer */
    public $Parent;
    /** @var RowOptionsDTO */
    public $Options;
    /** @var ColumnRenderer[] */
    public $Columns;

    public function __construct($options, $parent = null)
    {
        parent::__construct($options, $parent);
        $this->Columns=[];
        foreach($this->Options->Columns as $columnOptions)
        {
            $this->Columns[]=new ColumnRenderer($columnOptions,$this);
        }
    }

    public function GetUniqueId(){
        return 'Row_'.$this->Options->Id;
    }


    public function IsEmpty(){
        foreach($this->Columns as $currentColumn)
            if(!$currentColumn->IsEmpty())
                return false;
        return true;
    }

    protected function GetTemplateName()
    {
        return 'TwigManager/Renderers/RowRenderer.twig';
    }

    protected function InternalInitialize()
    {
        foreach ($this->Columns as $column)
            $column->Initialize();
    }

    public function GetChildren()
    {
        return $this->Columns;
    }
}