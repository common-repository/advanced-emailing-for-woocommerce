<?php 

namespace rnadvanceemailingwc\DTO;

class TextCanvasElementOptionsDTO extends CanvasElementOptionsDTO{
	/** @var string */
	public $Text;
	/** @var string */
	public $FontSize;
	/** @var string */
	public $FontFamily;
	/** @var string */
	public $TextAlignment;
	/** @var Numeric */
	public $CharSpacing;
	/** @var ShadowOptionsDTO */
	public $Shadow;
	/** @var ColorOptionsDTO */
	public $Color;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Text='Text (click me to edit)';
		$this->FontSize='20';
		$this->FontFamily='Verdana';
		$this->TextAlignment='center';
		$this->Type='Text';
		$this->CharSpacing=0;
		$this->Color=(new SolidColorOptionsDTO())->Merge();
		$this->Shadow=(new ShadowOptionsDTO())->Merge();
	}
	public function GetValueFromLoader($property,$value){
		switch($property){
			case "Color":
				return \rnadvanceemailingwc\DTO\core\Factories\ColorFactory::GetColorOptions($value);
			default:
				return parent::GetValueFromLoader($property, $value);
		}
	}
}

