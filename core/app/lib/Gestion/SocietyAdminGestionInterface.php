<?php 

namespace Lib\Gestion;

interface SocietyAdminGestionInterface {
	public function index($n);
	public function show($id);
	public function create();
	public function store();
	public function edit($id);
	public function update($id);
	public function destroy($id);
}