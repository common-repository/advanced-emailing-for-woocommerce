<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class EmailAddressDTO extends StoreBase{
	public $Type;
	/** @var string */
	public $Value;


	public function LoadDefaultValues(){
		$this->Value='';
		$this->Type=EmailAddressEnumDTO::$Fixed;
	}
}
