<?php 

namespace rnadvanceemailingwc\DTO;

class ImageBlockOptionsDTO extends BlockOptionsDTO{
	public $MediaData;
	/** @var Numeric */
	public $DisplayWidth;
	/** @var Numeric */
	public $DisplayHeight;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type=BlockTypeEnumDTO::$Image;
		$this->MediaData=null;
		$this->DisplayHeight=0;
		$this->DisplayWidth=0;
		$this->AddType("MediaData","Object");
	}
}

