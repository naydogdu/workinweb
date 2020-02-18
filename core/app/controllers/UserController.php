<?php

use Lib\Validation\UserCreateValidator as UserCreateValidator;
use Lib\Validation\UserUpdateValidator as UserUpdateValidator;
use Lib\Gestion\UserGestion as UserGestion;

class UserController extends BaseController {

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
		return View::make('admin.user.index', $this->user_gestion->index(5));
	}

	public function create()
	{
		return View::make('admin.user.create');
	}

	public function store()
	{
		if ($this->create_validation->fails()) {
		  return Redirect::route('user.create')
		  ->withInput()
		  ->withErrors($this->create_validation->errors());
		} else {
			$this->user_gestion->store();
			return Redirect::route('user.index')
			->with('status', Lang::get('admin.created'));
		}		
	}

	public function show($id)
	{
		return View::make('admin.user.show',  $this->user_gestion->show($id));
	}

    public function edit($id)
	{
		return View::make('admin.user.edit',  $this->user_gestion->edit($id));
	}

	public function update($id)
	{
		if ($this->update_validation->fails($id)) {
		  return Redirect::back()
		  ->withInput()
		  ->withErrors($this->update_validation->errors());
		} else {
			if(input::has('oldPassword')) 
			{
				$user = User::find($id);
				$user->pswd;
				if (Hash::check(Input::get('oldPassword'), $user->password) == false) {
		    		return Redirect::back()
		    		->withInput()
					->with('error',Lang::get('admin.wrongOldPassword'));
				}
			}
			$this->user_gestion->update($id);
			return Redirect::back()
			->with('status',Lang::get('admin.updated'));
		}		
	}

	public function destroy($id)
	{
		$this->user_gestion->destroy($id);
		return Redirect::back()
		->with('status',Lang::get('admin.deleted'));
	}

}
