<?php

use Lib\Gestion\TaskPublicAdminGestion as TaskPublicAdminGestion;
use Lib\Validation\TaskPublicUpdateValidator as UpdateValidation;

class TaskPublicAdminController extends \BaseController {

	protected $taskPublic_gestion;
	protected $update_validation;

	public function __construct(TaskPublicAdminGestion $taskPublic_gestion, UpdateValidation $update_validation)
	{
		$this->beforeFilter('admin');
		$this->taskPublic_gestion = $taskPublic_gestion;
		$this->update_validation = $update_validation;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('admin.taskPublic.index', $this->taskPublic_gestion->index());
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.taskPublic.create', $this->taskPublic_gestion->create());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if($this->update_validation->fails()) 
		{
			return Redirect::back()
            ->withErrors($this->update_validation->errors());
        } else {
        	$this->taskPublic_gestion->store();
        	return Redirect::route('taskpublic-admin.index')
        	->with('status', Lang::get('task.storeSuccess'));
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
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idTask)
	{
		if($this->update_validation->fails()) 
		{
			return Redirect::back()
            ->withErrors($this->update_validation->errors());
        } else {
        	$this->taskPublic_gestion->update($idTask);
        	return Redirect::back()
        	->with('status', Lang::get('task.editSuccess'));
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
		$taskPublic = TasksPublic::findOrFail($id);
		$taskPublic->forceDelete();
		return Redirect::back()
		->with('status', Lang::get('admin.deleteSuccessTask'));
	}


}
