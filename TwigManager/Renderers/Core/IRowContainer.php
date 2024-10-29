<?php

namespace rnadvanceemailingwc\TwigManager\Renderers\Core;


use rnadvanceemailingwc\DTO\RowOptionsDTO;
use rnadvanceemailingwc\TwigManager\Renderers\RowRenderer;

/**
 * @property RowsManager $RowsManager
 * @property RowRenderer[] $Rows
 */
interface IRowContainer
{
    /**
     * @return RowOptionsDTO[];
     */
    public function GetRowOptions();
}