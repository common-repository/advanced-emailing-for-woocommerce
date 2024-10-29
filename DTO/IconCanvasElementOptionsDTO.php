<?php 

namespace rnadvanceemailingwc\DTO;

class IconCanvasElementOptionsDTO extends CanvasElementOptionsDTO{
	/** @var string */
	public $IconName;
	/** @var string */
	public $IconSize;
	/** @var string */
	public $IconColor;
	/** @var ShadowOptionsDTO */
	public $Shadow;
	/** @var ColorOptionsDTO */
	public $Color;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='Icon';
		$this->IconName='fa fa-star';
		$this->IconSize='30';
		$this->IconColor='#000000';
		$this->Shadow=new ShadowOptionsDTO();;
		$this->Color=(new SolidColorOptionsDTO())->Merge();
	}
}

