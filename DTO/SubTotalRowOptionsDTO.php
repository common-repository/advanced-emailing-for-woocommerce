<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class SubTotalRowOptionsDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	public $Label;
	public $Content;
	/** @var string */
	public $SubTotalType;


	public function LoadDefaultValues(){
		$this->Label=null;
		$this->SubTotalType='None';
		$this->Content=null;
		$this->Id=0;
		$this->AddType("Label","Object");
		$this->AddType("Content","Object");
	}
}

