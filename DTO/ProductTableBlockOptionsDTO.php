<?php 

namespace rnadvanceemailingwc\DTO;

class ProductTableBlockOptionsDTO extends BlockOptionsDTO{
	/** @var ProductTableColumnOptionsDTO[] */
	public $Columns;
	/** @var SubTotalRowOptionsDTO[] */
	public $SubTotalRows;
	/** @var string */
	public $Style;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Id=0;
		$this->Style='default';
		$this->Type=BlockTypeEnumDTO::$ProductTable;
		$this->Columns=[];
		$this->SubTotalRows=[];
		$this->AddType("Columns","ProductTableColumnOptionsDTO");
		$this->AddType("SubTotalRows","SubTotalRowOptionsDTO");
	}
}

