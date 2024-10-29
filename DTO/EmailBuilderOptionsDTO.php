<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class EmailBuilderOptionsDTO extends StoreBase{
	/** @var HeaderOptionsDTO */
	public $HeaderOptions;
	/** @var ContentOptionsDTO */
	public $ContentOptions;
	/** @var TriggerBaseOptionsDTO[] */
	public $Triggers;
	/** @var string */
	public $Name;
	/** @var CustomFieldOptionsDTO[] */
	public $CustomFields;
	/** @var Numeric */
	public $Id;


	public function LoadDefaultValues(){
		$this->Id=0;
		$this->Triggers=[];
		$this->Name='';
		$this->HeaderOptions=(new HeaderOptionsDTO())->Merge();
		$this->ContentOptions=(new ContentOptionsDTO())->Merge();
		$this->CustomFields=[];
		$this->AddType("Triggers","TriggerBaseOptionsDTO");
		$this->AddType("CustomFields","CustomFieldOptionsDTO");
	}
	public function GetValueFromLoader($property,$value){
		switch($property){
			case "Triggers":
				return \rnadvanceemailingwc\DTO\core\Factories\TriggerFactory::GetTriggerList($value);
		}
	}
}

