<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements\FRField;

abstract class FRFieldSource
{
    public $IsFRDataSource=true;

    public abstract function GetText();

    public abstract function GetNumber();
    public abstract function GetPrice();
}