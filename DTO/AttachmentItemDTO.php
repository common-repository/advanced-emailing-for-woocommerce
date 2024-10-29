<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class AttachmentItemDTO extends StoreBase{
	/** @var string */
	public $Value;
	/** @var string */
	public $Label;
	public $Type;
	/** @var Numeric */
	public $AttachmentItemId;


	public function LoadDefaultValues(){
		$this->Value='';
		$this->Label='';
		$this->Type=AttachmentTypeEnumDTO::$File;
		$this->AttachmentItemId=0;
	}
}

