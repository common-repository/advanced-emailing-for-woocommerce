<?php

namespace rnadvanceemailingwc\TwigManager\Renderers\Core;

use rnadvanceemailingwc\TwigManager\Renderers\RowRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\SectionRenderer;

class SectionManager
{

    /** @var ISectionContainer */
    public $Instance;

    public function __construct($instance)
    {
        $this->Instance=$instance;
        foreach ($this->Instance->GetSectionOptions() as $currentRow)
        {
            $instance->Sections[]=new SectionRenderer($currentRow,$instance);

        }
    }

    public function Initialize(){
        foreach($this->Instance->Sections as $currentSection)
            $currentSection->Initialize();
    }

}