<?php

namespace rnadvanceemailingwc\TwigManager\Renderers\Blocks;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\Result\PngResult;
use rnadvanceemailingwc\DTO\ImageBlockOptionsDTO;
use rnadvanceemailingwc\DTO\QRCodeBlockOptionsDTO;
use rnadvanceemailingwc\Managers\FileManager;
use rnadvanceemailingwc\TwigManager\Renderers\Blocks\Core\BlockRendererBase;
use rnadvanceemailingwc\TwigManager\SimpleTextRenderer\SimpleTextRenderer;

class ImageBlockRenderer extends BlockRendererBase
{
    /** @var ImageBlockOptionsDTO */
    public $Options;
    public $QRCodeURL;
    public $Size;

    public function GetURL(){
        if($this->Options->MediaData==null||$this->Options->MediaData->URL=='')
            return '';

        return $this->Options->MediaData->URL;
    }

    public function GetWidth()
    {
        $size='auto';
        if($this->Options->DisplayWidth!='')
            $size=$this->Options->DisplayWidth.'px';
        return $size;
    }


    public function GetHeight()
    {
        $size='auto';
        if($this->Options->DisplayHeight!='')
            $size=$this->Options->DisplayHeight.'px';
        return $size;
    }

    protected function GetTemplateName()
    {
        return 'TwigManager/Renderers/Blocks/ImageBlockRenderer.twig';
    }
}