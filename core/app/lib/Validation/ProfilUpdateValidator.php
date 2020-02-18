<?php 

namespace Lib\Validation;

class ProfilUpdateValidator extends BaseValidator {

    public function __construct()
	{
		$this->regles = array(
			'first_name'		=> 'max:50',
			'last_name'			=> 'max:50',
			'birthday' 			=> 'date',
			'occupation'		=> 'max:50',
			'avatar'			=> 'image|mimes:jpg,jpeg,png,bmp,gif|max:10000'
		);
	}

}