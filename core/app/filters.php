<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	View::composer('*', function($view){
		View::share('view_name', $view->getName());
	});
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

// détermine si l'utilisateur est un admin.
// Si non, et qu'il est reconnus comme un user, il est redirigé vers la page public
Route::filter('admin', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('/');
		}
	}

	if (Auth::check())
	{
		if(Session::has('role'))
		{
			if(Session::get('role') !== 'admin') // détermine les roles ayant les droits d'accés
			{
				if(Session::get('role') == 'user' ) // Redirige les utilisateurs simple vers leur page.
				{
					return Redirect::to('public');
				} 
				else
				{ 
					return Redirect::to('/');
				}
			} 
		}
	}
});

// Détermine si l'utilisateur est connecté, et que son role est bien user ou admin
Route::filter('user', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('/');
		}
	}

	if (Auth::check())
	{
		if(Session::has('role'))
		{
			if(Session::get('role') !== 'user' && Session::get('role') !== 'admin') // détermine les roles ayant les droits d'accés
			{
				return Redirect::to('/');
			} 
		}
	}
});

Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check())
	{
		if(Session::has('role'))
		{
			if(Session::get('role') == 'admin')
			{
				return Redirect::to('public');
			} 
		}
	}	
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

