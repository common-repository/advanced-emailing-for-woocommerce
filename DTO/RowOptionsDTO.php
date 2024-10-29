<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class RowOptionsDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	/** @var ColumnOptionsDTO[] */
	public $Columns;
	/** @var string */
	public $Class;


	public function LoadDefaultValues(){
		$this->Columns=[];
		$this->Id=0;
		$this->Class='';
		$this->AddType("Columns","ColumnOptionsDTO");
	}
}

