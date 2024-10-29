<?php 

namespace rnadvanceemailingwc\DTO;

class GradientColorOptionsDTO extends ColorOptionsDTO{
	/** @var string */
	public $GradientType;
	/** @var ColorStopDTO[] */
	public $ColorStops;
	/** @var string */
	public $Position;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='Gradient';
		$this->ColorStops=[];
		$this->AddType("ColorStops","ColorStopDTO");
	}
}

