<?php 

namespace Lib\Gestion;

interface TaskGestionInterface {

	public function create($idProject);
	public function update($idTask, $idProject);
	public function edit($idTask, $idProject);
	public function store($idProject);

}