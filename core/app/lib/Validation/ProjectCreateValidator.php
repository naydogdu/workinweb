<?php 

namespace Lib\Validation;

class ProjectCreateValidator extends BaseValidator {

    public function __construct()
	{
		$this->regles = array(
			'title' => 'required|max:55',
			'description' => 'required|min:10'
		);
	}

}