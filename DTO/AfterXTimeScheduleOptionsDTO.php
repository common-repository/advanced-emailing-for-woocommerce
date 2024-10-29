<?php 

namespace rnadvanceemailingwc\DTO;

class AfterXTimeScheduleOptionsDTO extends ScheduleOptionsBaseDTO{
	/** @var string */
	public $Interval;
	/** @var string */
	public $IntervalType;


	public function LoadDefaultValues(){
		$this->Type='after_time';
		$this->IntervalType='days';
		$this->Interval='1';
	}
}

