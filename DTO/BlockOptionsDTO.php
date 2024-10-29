<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class BlockOptionsDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	public $Type;
	/** @var string */
	public $Class;


	public function LoadDefaultValues(){
		$this->Id=0;
		$this->Type=BlockTypeEnumDTO::$Paragraph;
		$this->Class='';
	}
}

