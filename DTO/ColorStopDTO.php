<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class ColorStopDTO extends StoreBase{
	/** @var string */
	public $Color;
	/** @var Numeric */
	public $Location;
	/** @var Numeric */
	public $Id;


	public function LoadDefaultValues(){
		$this->Color='#000000';
		$this->Location=0;
		$this->Id=0;
	}
}

