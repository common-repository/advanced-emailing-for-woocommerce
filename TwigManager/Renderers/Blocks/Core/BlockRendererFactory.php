<?php

namespace rnadvanceemailingwc\TwigManager\Renderers\Blocks\Core;

use rnadvanceemailingwc\DTO\BlockOptionsDTO;
use rnadvanceemailingwc\pr\Blocks\ButtonBlockRenderer;
use rnadvanceemailingwc\pr\Blocks\ProductRecommendationBlockRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\Blocks\ParagraphBlockRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\Blocks\ProductTableBlockRenderer;
use rnadvanceemailingwc\TwigManager\Renderers\Blocks\SubsectionBlockRenderer;

class BlockRendererFactory
{
    /**
     * @param $options BlockOptionsDTO
     * @return BlockRendererBase
     */
    public static function GetBlockRenderer($options,$parent){
        switch ($options->Type)
        {
            case 'Paragraph':
                return new ParagraphBlockRenderer($options,$parent);
            case 'ProductTable':
                return new ProductTableBlockRenderer($options,$parent);
            case 'Subsection':
                return new SubsectionBlockRenderer($options,$parent);
            case 'Button':
                return new ButtonBlockRenderer($options,$parent);
            case 'ProductRecommendation':
                return new ProductRecommendationBlockRenderer($options,$parent);
        }

        $block=null;
        $block= apply_filters('aefwc-get-block',$block,$options,$parent);
        if($block==null)
            throw new \Exception('Unknown block '.$options->Type);
        return $block;
    }

}