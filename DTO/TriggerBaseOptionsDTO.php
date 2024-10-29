<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class TriggerBaseOptionsDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	/** @var ConditionBaseOptionsDTO */
	public $Condition;
	/** @var string */
	public $Type;


	public function LoadDefaultValues(){
		$this->Id=0;
		$this->Type='';
		$this->Condition=null;
		$this->AddType("Condition","ConditionBaseOptionsDTO");
	}
}

