<?php 

namespace rnadvanceemailingwc\DTO;

class SubSectionBlockOptionsDTO extends BlockOptionsDTO{
	/** @var RowOptionsDTO[] */
	public $Rows;
	/** @var SectionOptionsDTO[] */
	public $Sections;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type=BlockTypeEnumDTO::$SubSection;
		$this->Rows=[];
		$this->Sections=[];
		$this->AddType("Rows","RowOptionsDTO");
		$this->AddType("Sections","SectionOptionsDTO");
	}
}

