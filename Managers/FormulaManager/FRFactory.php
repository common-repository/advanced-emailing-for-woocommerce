<?php

namespace rnadvanceemailingwc\Managers\FormulaManager;

use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRArray;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRAssigmentExpression;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRBinaryExpression;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRBlock;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRBool;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRBreak;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRCondE;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRFCExpression;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRField\FRField;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRFor;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRForE;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRIfStatement;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRMembE;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRNull;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRNumber;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRReturn;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRString;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRUnaryExpression;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRVariable;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\ParenthezisedExpression;

class FRFactory
{
    public static $FieldDictionary;

    private static function GetDictionary(){
        if(FRFactory::$FieldDictionary==null)
            FRFactory::$FieldDictionary=new \stdClass();

        return FRFactory::$FieldDictionary;

    }


    public static function GetFRElement($options,$parent){

        switch ($options->T)
        {
            case 'ARR':
                return new FRArray($options,$parent);
            case 'AE':
                return new FRAssigmentExpression($options,$parent);
            case 'BE':
                return new FRBinaryExpression($options,$parent);
            case 'BLO':
                return new FRBlock($options,$parent);
            case 'BL':
                return new FRBool($options,$parent);
            case 'BR':
                return new FRBreak($options,$parent);
            case 'VAR':
                return new FRVariable($options,$parent);
            case 'CE':
                return new FRCondE($options,$parent);
            case 'FC':
                return new FRFCExpression($options,$parent);
            case 'FOR':
                return new FRFor($options,$parent);
            case 'FE':
                return new FRForE($options,$parent);
            case 'IF':
                return new FRIfStatement($options,$parent);
            case 'ME':
                return new FRMembE($options,$parent);
            case 'Null':
                return new FRNull($options,$parent);
            case 'NUM':
                return new FRNumber($options,$parent);
            case 'RE':
                return new FRReturn($options,$parent);
            case 'STR':
                return new FRString($options,$parent);
            case "PE":
                return new ParenthezisedExpression($options,$parent);
            case 'UE':
                return new FRUnaryExpression($options,$parent);
            case 'RNF':
                return new FRField($options,$parent);
        }

        throw new \Exception('Undefined formula element '.$options->T);
    }

    public static function AddField($type,$field){
        FRFactory::GetDictionary()[$type]=$field;
    }
}