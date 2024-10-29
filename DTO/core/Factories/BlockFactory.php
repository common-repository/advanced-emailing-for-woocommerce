<?php

namespace rnadvanceemailingwc\DTO\core\Factories;

use rnadvanceemailingwc\DTO\ButtonBlockOptionsDTO;
use rnadvanceemailingwc\DTO\HeaderBuilderBlockOptionsDTO;
use rnadvanceemailingwc\DTO\IconsBlockOptionsDTO;
use rnadvanceemailingwc\DTO\ImageBlockOptionsDTO;
use rnadvanceemailingwc\DTO\ParagraphBlockOptionsDTO;
use rnadvanceemailingwc\DTO\ProductRecommendationBlockOptionsDTO;
use rnadvanceemailingwc\DTO\ProductTableBlockOptionsDTO;
use rnadvanceemailingwc\DTO\QRCodeBlockOptionsDTO;
use rnadvanceemailingwc\DTO\SubSectionBlockOptionsDTO;

class BlockFactory
{
    public static function GetBlockOptions($value)
    {
        $options=[];
        if($value==null)
            return $value;
        foreach($value as $currentBlock)
        {
            $currentOption=null;
            switch ($currentBlock->Type)
            {
                case 'Paragraph':
                    $currentOption=new ParagraphBlockOptionsDTO();
                    break;
                case 'Subsection':
                    $currentOption=new SubSectionBlockOptionsDTO();
                    break;
                case 'ProductTable':
                    $currentOption=new ProductTableBlockOptionsDTO();
                    break;
                case 'QRCode':
                    $currentOption=new QRCodeBlockOptionsDTO();
                    break;
                case 'Image':
                    $currentOption=new ImageBlockOptionsDTO();
                    break;
                case 'Icons':
                    $currentOption=new IconsBlockOptionsDTO();
                    break;
                case 'HeaderBuilder':
                    $currentOption=new HeaderBuilderBlockOptionsDTO();
                    break;
                case 'Button':
                    $currentOption=new ButtonBlockOptionsDTO();
                    break;
                case 'ProductRecommendation':
                    $currentOption=new ProductRecommendationBlockOptionsDTO();
                    break;
            }

            if($currentOption==null)
                throw new \Exception('Invalid block '.$currentBlock->Type);

            $currentOption->Merge($currentBlock);
            $options[]=$currentOption;
        }

        return $options;
    }
}