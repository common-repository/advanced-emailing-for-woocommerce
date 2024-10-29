<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class ScheduleOptionsBaseDTO extends StoreBase{
	/** @var string */
	public $Type;


	public function LoadDefaultValues(){
		$this->Type='';
	}
}

