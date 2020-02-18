<?php

use Lib\Validation\UserCreateValidator as UserCreateValidator;
use Lib\Validation\UserUpdateValidator as UserUpdateValidator;
use Lib\Gestion\UserGestion as UserGestion;

class AdminController extends BaseController {

    protected $create_validation;
	protected $update_validation;
	protected $user_gestion;

	public function __construct(
		UserCreateValidator $create_validation, 
		UserUpdateValidator $update_validation,
		UserGestion $user_gestion
		)
	{
		parent::__construct();
		$this->beforeFilter('admin');
		$this->create_validation = $create_validation;
		$this->update_validation = $update_validation;
		$this->user_gestion = $user_gestion;
	}

	public function index()
	{
		return View::make('admin.home');
	}

}


