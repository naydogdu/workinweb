<?php 

namespace Lib\Gestion;

interface ProfilGestionInterface {

    public function index($n);
	public function show($id);
	public function edit($id);
	public function update($id);
	public function destroy($id, $idUser);

}