<?php

namespace rnadvanceemailingwc\TwigManager\Renderers\Core;


use rnadvanceemailingwc\DTO\RowOptionsDTO;
use rnadvanceemailingwc\DTO\SectionOptionsDTO;
use rnadvanceemailingwc\TwigManager\Renderers\RowRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\SectionRenderer;

/**
 * @property SectionManager $SectionManager
 * @property SectionRenderer[] $Sections
 */
interface ISectionContainer
{
    /**
     * @return SectionOptionsDTO[];
     */
    public function GetSectionOptions();
}