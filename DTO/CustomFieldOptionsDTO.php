<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class CustomFieldOptionsDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	/** @var string */
	public $Name;
	/** @var string */
	public $Code;
	public $CompiledCode;
	/** @var string */
	public $PHPCode;
	/** @var string */
	public $CodeType;


	public function LoadDefaultValues(){
		$this->Id=0;
		$this->Name='';
		$this->CompiledCode=null;
		$this->PHPCode='';
		$this->Code='';
		$this->CodeType='simplified';
		$this->AddType("CompiledCode","Object");
	}
}

