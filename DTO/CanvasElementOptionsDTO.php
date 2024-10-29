<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class CanvasElementOptionsDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	/** @var string */
	public $Type;
	/** @var Numeric */
	public $ScaleX;
	/** @var Numeric */
	public $ScaleY;
	/** @var Numeric */
	public $Top;
	/** @var Numeric */
	public $Left;
	/** @var Numeric */
	public $Angle;
	/** @var Numeric */
	public $SkewX;
	/** @var Numeric */
	public $SkewY;
	/** @var Boolean */
	public $FlipX;
	/** @var Boolean */
	public $FlipY;


	public function LoadDefaultValues(){
		$this->Id=0;
		$this->ScaleX=1;
		$this->ScaleY=1;
		$this->SkewX=0;
		$this->SkewY=0;
		$this->Angle=0;
		$this->Top=0;
		$this->Left=0;
		$this->FlipX=false;
		$this->FlipY=false;
		$this->Type='';
	}
}

