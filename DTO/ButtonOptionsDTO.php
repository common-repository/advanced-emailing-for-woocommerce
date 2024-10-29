<?php 

namespace rnadvanceemailingwc\DTO;

class ButtonOptionsDTO extends BlockOptionsDTO{
	public $Text;
	public $URL;
	/** @var Numeric */
	public $Id;
	/** @var string */
	public $Style;
	/** @var string */
	public $BorderRadiusTopLeft;
	/** @var string */
	public $BorderRadiusTopRight;
	/** @var string */
	public $BorderRadiusBottomLeft;
	/** @var string */
	public $BorderRadiusBottomRight;
	/** @var string */
	public $BackgroundColor;
	/** @var string */
	public $FontFamily;
	/** @var string */
	public $FontSize;
	/** @var string */
	public $Color;
	/** @var string */
	public $PaddingTop;
	/** @var string */
	public $PaddingRight;
	/** @var string */
	public $PaddingBottom;
	/** @var string */
	public $PaddingLeft;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Style='ButtonStyle';
		$this->Text=null;
		$this->URL=null;
		$this->Id=0;
		$this->BorderRadiusTopLeft='';
		$this->BorderRadiusTopRight='';
		$this->BorderRadiusBottomLeft='';
		$this->BorderRadiusBottomRight='';
		$this->BackgroundColor='';
		$this->FontFamily='';
		$this->FontSize='';
		$this->Color='';
		$this->PaddingTop='';
		$this->PaddingRight='';
		$this->PaddingBottom='';
		$this->PaddingLeft='';
		$this->AddType("Text","Object");
		$this->AddType("URL","Object");
	}
}

