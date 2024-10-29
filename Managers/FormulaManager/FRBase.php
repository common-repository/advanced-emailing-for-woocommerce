<?php

namespace rnadvanceemailingwc\Managers\FormulaManager;

abstract class FRBase
{
    public $Options;
    /** @var FRBase */
    public $Parent;
    public function __construct($Options,$Parent)
    {
        $this->Options=$Options;
        $this->Parent=$Parent;
    }

    public function GetRetriever(){
        return $this->Parent->GetRetriever();
    }

    public function GetType(){
        return $this->Options->T;
    }

    public abstract function Parse();

}