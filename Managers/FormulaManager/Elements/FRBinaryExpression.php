<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements;

use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRField\FRFieldSource;
use rnadvanceemailingwc\Managers\FormulaManager\FRBase;
use rnadvanceemailingwc\Managers\FormulaManager\FRFactory;

class FRBinaryExpression extends FRBase
{
    /** @var FRBase */
    public $Left;
    /** @var FRBase */
    public $Right;
    public $Subtype;


    public function __construct($Options, $Parent)
    {
        parent::__construct($Options, $Parent);
        $this->Left = FRFactory::GetFRElement($Options->L, $this);
        $this->Right = FRFactory::GetFRElement($Options->R, $this);
        $this->Subtype = $Options->St;
    }

    public function Parse()
    {
        $left = $this->Left->Parse();
        $right = $this->Right->Parse();


        switch ($this->Subtype)
        {
            case 'Add':
                if ($left instanceof FRFieldSource)
                {
                    if (is_string($right)&&!is_numeric($right))
                        $left = $left->GetText();
                    else
                        $left = $left->GetNumber();


                } else
                {
                    if (!is_numeric($left))
                        $left = strval($left);
                    else
                        $left = floatval($left);
                }


                if ($right instanceof FRFieldSource)
                {
                    if (is_string($left)&&!is_numeric($left))
                        $right = $right->GetText();

                    else
                        $right = $right->GetNumber();

                } else
                {
                    if (!is_numeric($left))
                        $right = strval($right);
                    else
                        $right = floatval($right);
                }
                if (is_numeric($left) && is_numeric($right))
                    return $left + $right;
                else
                    return $left . $right;
            case 'Sub':
                return $this->ToNumber($left) - $this->ToNumber($right);
            case 'Mult':
                return $this->ToNumber($left) * $this->ToNumber($right);
            case 'Div':
                $right = $this->ToNumber($right);
                if ($right == 0)
                    return 0;
                return $this->ToNumber($left) / $right;
            case 'Eq':
                return $this->ToScalar($left) == $this->ToScalar($right);
            case 'NEq':
                return $this->ToScalar($left) != $this->ToScalar($right);
            case 'Gt':
                return $this->ToScalar($left) > $this->ToScalar($right);
            case 'Gte':
                return $this->ToScalar($left) >= $this->ToScalar($right);
            case 'Lt':
                return $this->ToScalar($left) < $this->ToScalar($right);
            case 'Lte':
                return $this->ToScalar($left) <= $this->ToScalar($right);

        }


    }

    private function ToScalar($parse)
    {
        if (is_array($parse))
        {
            $total = 0;
            foreach ($parse as $currentItem)
                $total .= $currentItem;
            return $total;
        }

        if ($parse instanceof FRFieldSource)
            return $parse->ToText();
        return $parse;
    }

    private function ToNumber($parse)
    {

        if (is_array($parse))
        {
            $total = 0;
            foreach ($parse as $currentItem)
                $total .= $currentItem;
            return $total;
        }

        if ($parse instanceof FRFieldSource)
            return $parse->ToNumber();

        if (!is_numeric($parse))
            return 0;
        $parse = floatval($parse);
        return $parse;
    }
}