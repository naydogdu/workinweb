<?php 

namespace Lib\Validation;

class TicketCreateValidator extends BaseValidator {

    public function __construct()
	{
		$this->regles = array(
			'content' => 'required|min:2'
		);
	}

}