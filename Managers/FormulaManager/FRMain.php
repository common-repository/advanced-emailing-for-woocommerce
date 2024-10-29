<?php

namespace rnadvanceemailingwc\Managers\FormulaManager;

use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRField\FRDataRetriever;
use rnadvanceemailingwc\Managers\FormulaManager\Elements\FRField\FRFieldSource;
use rnadvanceemailingwc\Utilities\Sanitizer;

class FRMain extends FRBase
{
    /** @var FRBase[] */
    public $Sentences=[];

    /** @var FRDataRetriever */
    private $_retriever;

    public $ShouldReturn=false;

    public function __construct($Options,$dataRetriever) {
        parent::__construct($Options,$dataRetriever);

        $this->_retriever=$dataRetriever;

        $d=Sanitizer::GetValueFromPath($Options,'d');
        if(is_array($d))
            foreach($Options->d as $sentence)
            {
                $this->Sentences[]=FRFactory::GetFRElement($sentence,$this);
            }
    }

    public function GetRetriever(){
        return $this->_retriever;
    }

    public function Parse(){
        $result=null;
        foreach($this->Sentences as $sentence)
        {
            $result=$sentence->Parse();
            if($this->ShouldReturn)
                break;
        }

         if($result instanceof  FRFieldSource)
             return $result->GetText();
        return $result;
    }

    public function GetType(){
        return "Main";
    }

    public function ReturnWasExecuted(){
        $this->ShouldReturn=true;
    }


}