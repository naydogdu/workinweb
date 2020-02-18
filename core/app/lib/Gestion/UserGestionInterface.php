<?php 

namespace Lib\Gestion;

interface UserGestionInterface {

    public function index($n);
	public function store();
	public function store_($pswd);
	public function storeInvitation($pswd, $id);
	public function show($id);
	public function edit($id);
	public function update($id);
	public function destroy($id);
	public function getRole($mail);

}