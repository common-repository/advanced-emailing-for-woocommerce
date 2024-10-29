<?php

namespace rnadvanceemailingwc\DTO\core\Factories;

use rnadvanceemailingwc\DTO\ColorOptionsDTO;
use rnadvanceemailingwc\DTO\LinearGradientColorOptionsDTO;
use rnadvanceemailingwc\DTO\PatternColorOptionsDTO;
use rnadvanceemailingwc\DTO\RadialGradientColorOptionsDTO;
use rnadvanceemailingwc\DTO\SolidColorOptionsDTO;

class ColorFactory
{
    /**
     * @param $value ColorOptionsDTO
     * @return ColorOptionsDTO
     */
    public static function GetColorOptions($value)
    {
        if($value==null)
            return null;
        if($value->Type=='Solid'){
            return (new SolidColorOptionsDTO())->Merge($value);
        }

        if($value->Type=='Pattern'){
            return (new PatternColorOptionsDTO())->Merge($value);
        }

        if($value->Type=='Gradient'){
            if($value->GradientType=='Linear'){
                return (new LinearGradientColorOptionsDTO())->Merge($value);
            }
            if($value->GradientType=='Radial'){
                return (new RadialGradientColorOptionsDTO())->Merge($value);
            }
        }

    }

}