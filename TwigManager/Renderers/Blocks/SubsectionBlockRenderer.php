<?php

namespace rnadvanceemailingwc\TwigManager\Renderers\Blocks;

use rnadvanceemailingwc\DTO\ParagraphBlockOptionsDTO;
use rnadvanceemailingwc\DTO\RowOptionsDTO;
use rnadvanceemailingwc\DTO\SectionOptionsDTO;
use rnadvanceemailingwc\DTO\SubSectionBlockOptionsDTO;
use rnadvanceemailingwc\TwigManager\Renderers\Blocks\Core\BlockRendererBase;
use rnadvanceemailingwc\TwigManager\Renderers\Core\ISectionContainer;
use rnadvanceemailingwc\TwigManager\Renderers\Core\SectionManager;
use rnadvanceemailingwc\TwigManager\Renderers\RowRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\SectionRenderer;

class SubsectionBlockRenderer extends BlockRendererBase implements ISectionContainer
{
    /** @var SubSectionBlockOptionsDTO */
    public $Options;
    /** @var SectionRenderer[] */
    public $Sections;
    /** @var SectionManager */
    public $SectionManager;

    public function __construct($options, $parent = null)
    {
        parent::__construct($options, $parent);
        $this->Sections=[];

        if(count($options->Rows)>0)
        {
            $options->Sections=[];
            $options->Sections[]=(new SectionOptionsDTO());
            ($options->Sections[0])->LoadDefaultValues();
            $options->Sections[0]->Rows=$options->Rows;
            $options->Rows=[];
        }

        $this->SectionManager=new SectionManager($this);
    }

    protected function InternalInitialize()
    {
        parent::InternalInitialize();
        $this->SectionManager->Initialize();
    }


    public function GetChildren()
    {
        return $this->Sections;
    }

    protected function GetTemplateName()
    {
        return 'TwigManager/Renderers/Blocks/SubsectionBlockRenderer.twig';
    }

    public function GetSectionOptions()
    {
        return $this->Options->Sections;
    }

    protected function GetFileObjects($validate=true,$basePath='')
    {
        $files=[];
        foreach($this->Sections as $currentSection)
        {
            foreach($currentSection->Rows as $currentRow)
            {
                foreach($currentRow->Columns as $currentColumn)
                {
                    foreach($currentColumn->Blocks as $currentBlock)
                    {
                        $files=array_merge($files,$currentBlock->GetFileToSave($validate,$basePath));
                    }
                }
            }
        }

        return $files;
    }
}