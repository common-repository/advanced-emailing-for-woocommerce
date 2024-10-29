<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class SectionOptionsDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	/** @var RowOptionsDTO[] */
	public $Rows;
	/** @var string */
	public $Class;


	public function LoadDefaultValues(){
		$this->Rows=[];
		$this->Id=0;
		$this->Class='';
		$this->AddType("Rows","RowOptionsDTO");
	}
}

