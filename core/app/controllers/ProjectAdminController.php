<?php
use Lib\Gestion\ProjectAdminGestion as ProjectGestion;

class ProjectAdminController extends \BaseController {

	protected $gestion_project;

	public function __construct(ProjectGestion $gestion_project)
	{
		parent::__construct();
		$this->beforeFilter('admin');
		$this->gestion_project = $gestion_project;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('admin.project.index', $this->gestion_project->index(5));
	}
}
