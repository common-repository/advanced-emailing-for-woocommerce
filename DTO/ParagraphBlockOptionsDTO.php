<?php 

namespace rnadvanceemailingwc\DTO;

class ParagraphBlockOptionsDTO extends BlockOptionsDTO{
	public $Content;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type=BlockTypeEnumDTO::$Paragraph;
		$this->Content=null;
		$this->AddType("Content","Object");
	}
}

