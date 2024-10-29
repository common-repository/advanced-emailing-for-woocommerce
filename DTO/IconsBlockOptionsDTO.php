<?php 

namespace rnadvanceemailingwc\DTO;

class IconsBlockOptionsDTO extends BlockOptionsDTO{
	/** @var IconItemDTO[] */
	public $Icons;
	/** @var string */
	public $IconSize;
	/** @var string */
	public $IconColor;
	/** @var string */
	public $IconType;
	/** @var string */
	public $IconBackgroundColor;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->IconType='simple';
		$this->Type=BlockTypeEnumDTO::$Icons;
		$this->Icons=[];
		$this->IconSize='30';
		$this->IconColor='#000000';
		$this->IconBackgroundColor='#000000';
		$this->AddType("Icons","IconItemDTO");
	}
}

