<?php 

use Lib\Validation\ProfilUpdateValidator as ProfilUpdateValidator;
use Lib\Gestion\PublicGestion as PublicGestion; 

class PublicController extends BaseController {

	protected $update_validation;
	protected $public_gestion;

	public function __construct(
		ProfilUpdateValidator $update_validation,
		PublicGestion $public_gestion
	) {
		$this->beforeFilter('user');
		$this->update_validation = $update_validation;
		$this->public_gestion = $public_gestion;
	}

	public function index()
	{
		$id = Auth::id();
		return View::make('home', $this->public_gestion->index($id));
	}
}