<?php

namespace rnadvanceemailingwc\Fields\Core;

use rnadvanceemailingwc\core\Loader;

class OrderRetriever
{
    /** @var Loader */
    public $Loader;
    public $IsTest=false;
    /** @var \WC_Order */
    protected $RealOrder;
    public $Items=null;
    public $CurrentItem;
    private $Metas;
    /** @var OrderProxy  */
    public $Order;

    public function __construct($loader,$order=null)
    {
        $this->Metas=[];
        $this->RealOrder=$order;
        $this->Loader=$loader;
        $this->Order=$this->CreateProxy();
    }

    public function GetWCOrder(){
        return $this->RealOrder;
    }

    public function CreateProxy()
    {
        return new OrderProxy($this->RealOrder);
    }

    public function GetOrderURL()
    {
        return $this->Order->GetViewOrderURL();
    }

    public function GetFieldById( $fieldId)
    {
        return FieldFactory::GetField($fieldId,null,$this,null);
    }


    protected function CreateItems()
    {

    }

    public function SetCurrentOrderLine($currentItem)
    {
        $this->CurrentItem=$currentItem;
    }

    public function GetCurrentOrderLine($getFirstIfEmpty=true){
        if($this->CurrentItem==null&&$getFirstIfEmpty)
            $this->CurrentItem=current($this->Order->GetItems());
        return $this->CurrentItem;
    }

    public function AddMeta($name,$value)
    {
        $this->Metas[$name]=$value;
    }

    public function RemoveMeta($name)
    {
        if(isset($this->Metas[$name]))
            unset($this->Metas[$name]);
    }

    public function GetMeta($name,$default='')
    {
        if(!isset($this->Metas[$name]))
            return $default;
        return $this->Metas[$name];
    }

    public function GetVar($varName){
        if($varName=='order')
            return $this->Order;

        if($varName=='item')
            return $this->GetCurrentOrderLine();
        return null;

    }
}