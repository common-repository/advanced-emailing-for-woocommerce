<?php 

namespace rnadvanceemailingwc\DTO;

class PatternColorOptionsDTO extends ColorOptionsDTO{
	/** @var string */
	public $Repeat;
	public $ImageData;
	/** @var string */
	public $Position;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='Pattern';
		$this->Repeat='no-repeat';
		$this->ImageData=null;
		$this->Position='center center';
		$this->AddType("ImageData","Object");
	}
}

