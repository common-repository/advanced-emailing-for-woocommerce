<?php

namespace rnadvanceemailingwc\Managers\FormulaManager\Elements\FRField;

abstract class FRDataRetriever
{
    public $FunctionDictionary=[];
    public $VarDictionary=[];
    public function __construct()
    {

    }

    /**
     * @param $id
     * @return FRFieldSource
     */
    public abstract function GetFieldById($id);

    public function SetVar($varName,$value)
    {
        $this->VarDictionary[$varName]=$value;
    }

    public function &GetVar($varName)
    {
        $null=null;
        if(!isset($this->VarDictionary[$varName]))
            return $null;

        return $this->VarDictionary[$varName];
    }

    public function AddFunction($functionName,$functionObj)
    {
        $this->FunctionDictionary[$functionName]=$functionObj;
    }

    public function CallFunction($functionName,$args)
    {
        if(!isset($this->FunctionDictionary[$functionName]))
            return null;

        $args=array_merge([$this],$args);
        return call_user_func($this->FunctionDictionary[$functionName],...$args);
    }

}