<?php 

namespace rnadvanceemailingwc\DTO;

class QRCodeBlockOptionsDTO extends BlockOptionsDTO{
	public $Content;
	/** @var Numeric */
	public $Size;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type=BlockTypeEnumDTO::$QRCode;
		$this->Content=null;
		$this->Size=150;
		$this->AddType("Content","Object");
	}
}

