<?php 

namespace rnadvanceemailingwc\DTO;

class XDayOfMonthScheduleDTO extends ScheduleOptionsBaseDTO{


	public function LoadDefaultValues(){
		$this->Type='specific_date';
	}
}

