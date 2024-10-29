<?php

namespace rnadvanceemailingwc\TwigManager\Renderers\Core\TextRenderer;

use rnadvanceemailingwc\TwigManager\Renderers\DivRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\FieldRenderer\FieldRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\HeadingRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\ParagraphRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\ProductHeaderCellRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\ProductRowRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\ProductTHeadRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\SimpleContainerRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\TableCellRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\TableRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\TableRowRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\TextRenderer;

class RenderFactory
{

    public static function GetRenderer($content,$parent)
    {
        if($content==null)
            return null;

        if(!isset($content->type))
            throw new \Exception('This renderer does not have a type');

        switch ($content->type)
        {
            case 'div':
                return new DivRenderer($content,$parent);
            case 'table':
            case 'template_table':
            case 'product_table':
                return new TableRenderer($content,$parent);
            case 'template_row':
            case 'table_row':
                return new TableRowRenderer($content,$parent);
            case 'template_cell':
                return new TableCellRenderer($content,$parent);
            case 'heading':
                return new HeadingRenderer($content,$parent);
            case 'text':
                return new TextRenderer($content,$parent);
            case 'field':
                return new FieldRenderer($content,$parent);
            case 'paragraph':
                return new ParagraphRenderer($content,$parent);
            case 'thead':
            case 'product_thead':
                return new SimpleContainerRenderer($content,$parent,'thead');
            case 'product_tbody':
                return new SimpleContainerRenderer($content,$parent,'tbody');
            case 'product_row':
                return new ProductRowRenderer($content,$parent);
            case 'product_header_cell':
                return new SimpleContainerRenderer($content,$parent,'th');
            case 'product_cell':
            case 'table_cell':
                return new SimpleContainerRenderer($content,$parent,'td');
            case 'product_tfoot':
                return new SimpleContainerRenderer($content,$parent,'tfoot');
            default:
                throw new \Exception('No renderer found for type '.$content->type);
        }
    }

}