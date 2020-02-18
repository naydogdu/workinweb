<?php 

namespace Lib\Validation;

class UserUpdateValidator extends BaseValidator {

    public function __construct()
	{
		$this->regles = array(
			'email' 		=> 'email|unique:users,email,id',
			'password' 		=> 'min:6|confirmed|same:password_confirmation',
			'email_1' 		=> 'email|unique:users,email,id|same:email_1_confirmation',
			'password_1' 	=> 'min:6|required_with:oldPassword|same:password_1_confirmation',
			'oldPassword'	=> 'required_with:password_1',
		);
	}

}