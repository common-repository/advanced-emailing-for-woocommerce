<?php 

namespace rnadvanceemailingwc\DTO;

use rnadvanceemailingwc\DTO\core\StoreBase;

class HeaderOptionsDTO extends StoreBase{
	/** @var EmailAddressDTO[] */
	public $To;
	/** @var EmailAddressDTO[] */
	public $ReplyTo;
	/** @var EmailAddressDTO[] */
	public $CC;
	/** @var EmailAddressDTO[] */
	public $BCC;
	/** @var string */
	public $FromName;
	/** @var string */
	public $FromEmailAddress;
	public $Subject;


	public function LoadDefaultValues(){
		$this->To=[];
		$this->ReplyTo=[];
		$this->CC=[];
		$this->BCC=[];
		$this->FromName='';
		$this->FromEmailAddress='';
		$this->Subject=null;
		$this->AddType("To","EmailAddressDTO");
		$this->AddType("ReplyTo","EmailAddressDTO");
		$this->AddType("CC","EmailAddressDTO");
		$this->AddType("BCC","EmailAddressDTO");
		$this->AddType("Subject","Object");
	}
}

