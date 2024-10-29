<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class ContentOptionsDTO extends StoreBase{
	/** @var RowOptionsDTO[] */
	public $Rows;
	/** @var string */
	public $Template;
	/** @var string */
	public $Styles;
	/** @var Boolean */
	public $SplitOrder;
	/** @var ScheduleOptionsBaseDTO */
	public $Schedule;
	/** @var AttachmentItemDTO[] */
	public $Attachments;
	/** @var SectionOptionsDTO[] */
	public $Sections;


	public function LoadDefaultValues(){
		$this->Rows=[];
		$this->Template='';
		$this->Styles='';
		$this->SplitOrder=false;
		$this->Schedule=null;
		$this->Attachments=[];
		$this->Sections=[];
		$this->AddType("Rows","RowOptionsDTO");
		$this->AddType("Schedule","ScheduleOptionsBaseDTO");
		$this->AddType("Attachments","AttachmentItemDTO");
		$this->AddType("Sections","SectionOptionsDTO");
	}
	public function GetValueFromLoader($property,$value){
		switch($property){
			case "Schedule":
				return \rnadvanceemailingwc\DTO\core\Factories\ScheduleFactory::GetClass($value);
			default:
				return parent::GetValueFromLoader($property, $value);
		}
	}
}

