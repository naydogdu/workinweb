<?php 

namespace Lib\Validation;

class SocietyUpdateValidator extends BaseValidator {

    public function __construct()
	{
		$this->regles = array(
			'nameSociety'	=> 'required|max:200',
			'siret' 		=> 'required|unique:societys,siret,id|min:10000000000000|max:99999999999999|numeric',
			'creator'		=> 'required|not_in:null',
			'email'			=> 'email|same:email_confirmation',
		);
	}

}