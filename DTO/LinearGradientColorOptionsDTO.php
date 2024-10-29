<?php 

namespace rnadvanceemailingwc\DTO;

class LinearGradientColorOptionsDTO extends GradientColorOptionsDTO{


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->GradientType='Linear';
		$this->Position='top';
	}
}

