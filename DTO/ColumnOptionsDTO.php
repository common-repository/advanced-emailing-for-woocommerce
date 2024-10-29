<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class ColumnOptionsDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	/** @var BlockOptionsDTO[] */
	public $Blocks;
	/** @var Numeric */
	public $WidthPercentage;
	/** @var string */
	public $Align;
	/** @var string */
	public $Class;


	public function LoadDefaultValues(){
		$this->Id=0;
		$this->Blocks=[];
		$this->WidthPercentage=100;
		$this->Align='top';
		$this->Class='';
		$this->AddType("Blocks","BlockOptionsDTO");
	}
	public function GetValueFromLoader($property,$value){
		switch($property){
			case "Blocks":
				return \rnadvanceemailingwc\DTO\core\Factories\BlockFactory::GetBlockOptions($value);
			default:
				return parent::GetValueFromLoader($property, $value);
		}
	}
}

