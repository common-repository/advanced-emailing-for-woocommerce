<?php 

namespace rnadvanceemailingwc\DTO;

class SolidColorOptionsDTO extends ColorOptionsDTO{
	/** @var string */
	public $Color;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='Solid';
		$this->Color='#000000';
	}
}

