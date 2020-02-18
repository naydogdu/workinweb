<?php 

namespace Lib\Gestion;

interface ProjectGestionInterface {

	public function index($id);
	public function show($generated_url);
    public function create($id);
    public function update($generated_url);
    public function store($id);

}