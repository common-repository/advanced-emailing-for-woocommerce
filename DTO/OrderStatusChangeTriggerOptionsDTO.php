<?php 

namespace rnadvanceemailingwc\DTO;

class OrderStatusChangeTriggerOptionsDTO extends TriggerBaseOptionsDTO{
	/** @var String[] */
	public $FromStatus;
	/** @var String[] */
	public $ToStatus;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->FromStatus=[];
		$this->ToStatus=[];
		$this->Type='order_status_change';
		$this->AddType("FromStatus","String");
		$this->AddType("ToStatus","String");
	}
}

