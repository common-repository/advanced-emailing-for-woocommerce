<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class IconItemDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	/** @var string */
	public $Name;
	/** @var string */
	public $Label;
	public $URL;


	public function LoadDefaultValues(){
		$this->Id=0;
		$this->Name='';
		$this->Label='';
		$this->URL=null;
		$this->AddType("URL","Object");
	}
}

