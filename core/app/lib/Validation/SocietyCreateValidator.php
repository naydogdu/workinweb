<?php 

namespace Lib\Validation;

class SocietyCreateValidator extends BaseValidator {

    public function __construct()
	{
		$this->regles = array(
			'nameSociety'	=> 'required|max:200',
			'siret' 		=> 'required|unique:societys,siret|min:10000000000000|max:99999999999999|numeric',
			'creator'		=> 'required|not_in:null',
		);
	}

}