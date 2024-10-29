<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Utilities;

use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRField\FRFieldSource;

class FRUtilities
{
    public static function SanitizeNumber($val, $defaultValue = 0)
    {
        if ($val == null)
            return $defaultValue;

        if ($val instanceof FRFieldSource)
            return $val->ToNumber();

        if (!is_numeric($val))
            return $defaultValue;

        return floatval($val);

    }

    public static function NotifyReturnToParent($element)
    {
        while (!in_array($element->Parent->Options->T, ['BLO', 'MA', 'FOR', 'FE']))
        {
            $element = $element->Parent;
        }

        $element->Parent->ReturnWasExecuted();
    }

    public static function NotifyBreakToParent($element)
    {
        while (!in_array($element->Parent->Options->T, ['FOR', 'FE']))
        {
            $element = $element->Parent;
        }

        $element->Parent->BreakWasExecuted();
    }
}