<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class ShadowOptionsDTO extends StoreBase{
	/** @var Boolean */
	public $Enabled;
	/** @var string */
	public $Color;
	/** @var Numeric */
	public $Blur;
	/** @var Numeric */
	public $OffsetX;
	/** @var Numeric */
	public $OffsetY;


	public function LoadDefaultValues(){
		$this->Enabled=false;
		$this->Color='#000000';
		$this->Blur=1;
		$this->OffsetX=1;
		$this->OffsetY=1;
	}
}

