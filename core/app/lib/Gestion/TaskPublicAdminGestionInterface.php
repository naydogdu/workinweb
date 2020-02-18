<?php 

namespace Lib\Gestion;

interface TaskPublicAdminGestionInterface {

	public function index();
	public function update($idTask);
	public function create();
	public function store();

}