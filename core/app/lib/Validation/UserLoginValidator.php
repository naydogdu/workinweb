<?php 

namespace Lib\Validation;

class UserLoginValidator extends BaseValidator {

    public function __construct()
	{
		$this->regles = array(
			'email' => 'required|exists:users'
		);
	}

}