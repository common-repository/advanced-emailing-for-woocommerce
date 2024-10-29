<?php 

namespace rnadvanceemailingwc\DTO;

class ProductRecommendationBlockOptionsDTO extends BlockOptionsDTO{
	/** @var string */
	public $RecommendationType;
	/** @var Numeric */
	public $NumberOfRecommendations;
	/** @var Numeric */
	public $NumberOfColumns;
	/** @var string */
	public $Style;
	/** @var String[] */
	public $IncludeElements;
	public $Label;
	/** @var string */
	public $ButtonLabel;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type=BlockTypeEnumDTO::$ProductRecommendation;
		$this->RecommendationType='Linked products';
		$this->NumberOfRecommendations=4;
		$this->NumberOfColumns=2;
		$this->Style='Vertical';
		$this->IncludeElements=[];
		$this->Label=null;
		$this->ButtonLabel='View Product';
		$this->AddType("IncludeElements","String");
		$this->AddType("Label","Object");
	}
}

