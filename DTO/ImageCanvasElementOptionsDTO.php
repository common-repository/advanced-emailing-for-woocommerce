<?php 

namespace rnadvanceemailingwc\DTO;

class ImageCanvasElementOptionsDTO extends CanvasElementOptionsDTO{
	public $ImageData;
	/** @var ShadowOptionsDTO */
	public $Shadow;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='Image';
		$this->ImageData=null;
		$this->Shadow=(new ShadowOptionsDTO())->Merge();
		$this->AddType("ImageData","Object");
	}
}

