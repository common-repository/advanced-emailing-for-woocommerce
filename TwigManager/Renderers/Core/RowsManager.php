<?php

namespace rnadvanceemailingwc\TwigManager\Renderers\Core;

use rnadvanceemailingwc\TwigManager\Renderers\RowRenderer;

class RowsManager
{

    /** @var IRowContainer */
    public $Instance;

    public function __construct($instance)
    {
        $this->Instance=$instance;
        foreach ($this->Instance->GetRowOptions() as $currentRow)
        {
            $instance->Rows[]=new RowRenderer($currentRow,$instance);

        }
    }

    public function Initialize(){
        foreach($this->Instance->Rows as $currentRow)
            $currentRow->Initialize();
    }

}