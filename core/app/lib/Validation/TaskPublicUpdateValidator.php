<?php 

namespace Lib\Validation;

class TaskPublicUpdateValidator extends BaseValidator {

    public function __construct()
	{
		$this->regles = array(
			'title' 		=> 'required|min:4'
		);
	}

}