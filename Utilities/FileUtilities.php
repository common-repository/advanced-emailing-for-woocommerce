<?php

namespace rnadvanceemailingwc\Utilities;

class FileUtilities
{
    public static function IsImage($filePath)
    {
        return getimagesize($filePath) !== false;
    }
}