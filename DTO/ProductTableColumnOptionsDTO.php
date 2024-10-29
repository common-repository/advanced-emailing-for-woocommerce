<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class ProductTableColumnOptionsDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	public $Header;
	public $Content;


	public function LoadDefaultValues(){
		$this->Header=null;
		$this->Content=null;
		$this->Id=0;
		$this->AddType("Header","Object");
		$this->AddType("Content","Object");
	}
}

