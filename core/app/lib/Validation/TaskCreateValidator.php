<?php 

namespace Lib\Validation;

class TaskCreateValidator extends BaseValidator {

    public function __construct()
	{
		$this->regles = array(
			'title' 		=> 'required|min:4',
			'participant'	=> 'required',
		);
	}

}