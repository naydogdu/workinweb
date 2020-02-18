<?php 

namespace Lib\Validation;

class UserCreateWithoutPassValidator extends BaseValidator {

    public function __construct()
	{
		$this->regles = array(
			'email' => 'required|email|unique:users',
			//'password' => 'required|min:6', //|same:Confirmation_mot_de_passe
		);
	}

}