<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class ElementUsedOptionsDTO extends StoreBase{
	public $Type;
	public $Id;


	public function LoadDefaultValues(){
		$this->Type=ElementUsedTypeEnumDTO::$Field;
		$this->Id='';
	}
}

