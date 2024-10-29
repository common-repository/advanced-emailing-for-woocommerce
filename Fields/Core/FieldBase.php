<?php

namespace rnadvanceemailingwc\Fields\Core;

use rnadvanceemailingwc\Utilities\TreeSeeker\INode;

abstract class FieldBase implements INode
{
    public $Options;
    /** @var OrderRetriever */
    public $OrderRetriever;
    /** @var INode */
    public $Parent=null;
    public $SerializedOptions=null;
    public function __construct($options,$orderRetriever,$parent=null)
    {
        $this->Options=$options;
        $this->OrderRetriever=$orderRetriever;
        $this->Parent=$parent;
    }


    public function GetOptionsAttribute($attributeName,$default='')
    {
        if($this->SerializedOptions==null)
        {
            $this->SerializedOptions = json_decode($this->Options);
            if($this->SerializedOptions==null)
                $this->SerializedOptions=(Object)[];
        }
        if(isset($this->SerializedOptions->$attributeName))
            return $this->SerializedOptions->$attributeName;
        return $default;
    }
    public  function ToText(){
        if($this->OrderRetriever->IsTest)
            return $this->InternalTestText();
        return $this->InternalToText();
    }

    public  function ToHTML(){
        if($this->OrderRetriever->IsTest)
            return $this->InternalTestHTML();
        return $this->InternalToHtml();
    }

    public function InternalToHtml(){
        return $this->ToText();
    }

    public function InternalTestHTML(){
        return $this->ToText();
    }

    public abstract function InternalToText();
    public abstract function InternalTestText();

    public function GetParent(){
        return $this->Parent;
    }

    public function ToNumber(){
        if(is_numeric($this->ToText()))
            return intval($this->ToText());
        return 0;
    }



}