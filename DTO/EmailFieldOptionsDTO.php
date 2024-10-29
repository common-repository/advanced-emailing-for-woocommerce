<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class EmailFieldOptionsDTO extends StoreBase{
	/** @var string */
	public $Id;


	public function LoadDefaultValues(){
		$this->Id='';
	}
}

