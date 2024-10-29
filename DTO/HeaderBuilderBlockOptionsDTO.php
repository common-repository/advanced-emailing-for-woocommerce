<?php 

namespace rnadvanceemailingwc\DTO;

class HeaderBuilderBlockOptionsDTO extends BlockOptionsDTO{
	/** @var CanvasElementOptionsDTO[] */
	public $Elements;
	/** @var Numeric */
	public $Width;
	/** @var Numeric */
	public $Height;
	public $BackgroundImage;
	/** @var ColorOptionsDTO */
	public $BackgroundColor;
	/** @var string */
	public $BackgroundPosition;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type=BlockTypeEnumDTO::$HeaderBuilder;
		$this->Elements=[];
		$this->Width=0;
		$this->Height=300;
		$this->BackgroundImage=null;
		$this->BackgroundPosition='center';
		$this->BackgroundColor=(new ColorOptionsDTO())->Merge();
		$this->AddType("Elements","CanvasElementOptionsDTO");
		$this->AddType("BackgroundImage","Object");
		$this->AddType("BackgroundColor","ColorOptionsDTO");
	}
	public function GetValueFromLoader($property,$value){
		switch($property){
			case "Elements":
				return \rnadvanceemailingwc\DTO\core\Factories\CanvasElementFactory::CreateElementOptions($value);
			case "BackgroundColor":
				return \rnadvanceemailingwc\DTO\core\Factories\ColorFactory::GetColorOptions($value);
			default:
				return parent::GetValueFromLoader($property, $value);
		}
	}
}

