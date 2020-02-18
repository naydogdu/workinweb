<?php
use Lib\Gestion\SocietyAdminGestion as SocietyGestion;
use Lib\Gestion\UserGestion as UserGestion;
use Lib\Validation\SocietyCreateValidator as SocietyCreateValidator;
use Lib\Validation\SocietyUpdateValidator as SocietyUpdateValidator;



class SocietyAdminController extends \BaseController {

	protected $gestion_society;
	protected $user_gestion;
	protected $create_validation;
	protected $update_validation;

	public function __construct(
		SocietyGestion $gestion_society,
		SocietyCreateValidator $create_validation,
		SocietyUpdateValidator $update_validation,
		UserGestion $user_gestion)
	{
		parent::__construct();
		$this->beforeFilter('admin');
		$this->gestion_society = $gestion_society;
		$this->create_validation = $create_validation;
		$this->update_validation = $update_validation;
		$this->user_gestion = $user_gestion;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('admin.society.index', $this->gestion_society->index(15));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.society.create', $this->gestion_society->create());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if ($this->create_validation->fails()) {
		  return Redirect::route('society-admin.create')
		  ->withInput()
		  ->withErrors($this->create_validation->errors());
		} else {
			$this->gestion_society->store();
			return Redirect::route('society-admin.index')
			->with('status', Lang::get('admin.createdSociety'));
		}	
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return View::make('admin.society.show', $this->gestion_society->show($id));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return View::make('admin.society.edit', $this->gestion_society->edit($id));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
		if ($this->update_validation->fails($id)) {
		  return Redirect::route('society-admin.edit', $id)
		  ->withInput()
		  ->withErrors($this->update_validation->errors());
		} else {
			if($this->gestion_society->update($id))
			{
				return Redirect::route('society-admin.edit', $id)
					->with('status', Lang::get('admin.updatedSociety'));
			} 
			else 
			{
				$pswd =strstr(Input::get('email'), '@', true).str_random(7);
				$this->user_gestion->storeInvitation($pswd, $id);
				$this->invitationMail($pswd);
				return Redirect::route('society-admin.edit', $id)
					->with('status', Lang::get('admin.invitationSend'));
			}
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->gestion_society->destroy($id);
		return Redirect::back()
		->with('status',Lang::get('admin.deletedSociety'));
	}

	public function invitationMail($pswd)
	{
		Mail::send('emails.invitation.invitation',array ('pswd' => $pswd, 'email' => Input::get('email')), function($m)
		{
			$m->to(Input::get('email'), Input::get('email') )->subject(Lang::get('admin.mail.subject'));
		});
	}

}
