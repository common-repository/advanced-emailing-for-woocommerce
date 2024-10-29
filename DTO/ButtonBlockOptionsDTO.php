<?php 

namespace rnadvanceemailingwc\DTO;

class ButtonBlockOptionsDTO extends BlockOptionsDTO{
	/** @var ButtonOptionsDTO[] */
	public $Buttons;
	/** @var string */
	public $Separator;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type=BlockTypeEnumDTO::$Button;
		$this->Separator='';
		$this->Buttons=[];
		$this->AddType("Buttons","ButtonOptionsDTO");
	}
}

