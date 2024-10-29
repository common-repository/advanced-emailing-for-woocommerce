<?php

namespace rnadvanceemailingwc\DTO\core\Factories;

use rnadvanceemailingwc\DTO\IconCanvasElementOptionsDTO;
use rnadvanceemailingwc\DTO\ImageCanvasElementOptionsDTO;
use rnadvanceemailingwc\DTO\TextCanvasElementOptionsDTO;

class CanvasElementFactory
{
    public static function CreateElementOptions($value)
    {
        if($value==null)
            return [];
        $result=[];
        foreach ($value as $current)
        {
            $result[]=self::CreateElementOption($current);
        }
        return $result;
    }
    public static function CreateElementOption($value)
    {
        if($value==null)
            return null;
        switch ($value->Type)
        {
            case 'Text':
                return (new TextCanvasElementOptionsDTO())->Merge($value);
            case 'Icon':
                return (new IconCanvasElementOptionsDTO())->Merge($value);
            case 'Image':
                return (new ImageCanvasElementOptionsDTO())->Merge($value);
            default:
                throw new \Exception('Invalid canvas option '.$value->Type);
        }
    }

}