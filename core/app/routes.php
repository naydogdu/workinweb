<?php

Route::get('/', ['uses' => 'AuthController@getLogin', 'as' => 'connection.login']); // Home login
Route::post('/', ['uses' => 'AuthController@postRegister']); // Send register
if(null !==Input::get('loggedout')) { 
	Route::get('/', ['uses' => 'AuthController@getLogout', 'as' => 'logouturl']); // loggedout
}
//admin
Route::resource('admin', 'AdminController', array('only' => array('index'))); // Home admin
Route::resource('user', 'UserController');	//list user
Route::resource('project-admin', 'ProjectAdminController', array('only' => array('index'))); // list project
Route::resource('society-admin', 'SocietyAdminController');
Route::resource('taskpublic-admin', 'TaskPublicAdminController');

//public
Route::resource('public', 'PublicController'); // Home user
Route::resource('profil', 'ProfilController');


Route::resource('task.tickets', 'TaskTicketController');
Route::resource('task', 'TaskController');
Route::put('task/restore/{id}', ['uses' => 'TaskController@restore', 'as' => 'restoreTask']);
Route::put('task/addPublicTask/{id}', ['uses' => 'TaskController@addPublicTask', 'as' => 'addPublicTask']);

Route::resource('project', 'ProjectController');
Route::put('project/restore/{id}', ['uses' => 'ProjectController@restore', 'as' => 'restoreProject']);
Route::get('project/{generated}', ['uses' => 'ProjectController@show', 'as' => 'projectShow']);

Route::resource('auth', 'AuthController');
Route::controller('auth', 'AuthController');

Route::resource('ticket', 'TicketController');
