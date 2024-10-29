<?php 

namespace rnadvanceemailingwc\DTO;

class RadialGradientColorOptionsDTO extends GradientColorOptionsDTO{
	/** @var string */
	public $Position;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->GradientType='Radial';
		$this->Position='center center';
	}
}

