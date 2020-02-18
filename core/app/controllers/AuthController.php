<?php

use Lib\Validation\UserLoginValidator as UserLoginValidator;
use Lib\Validation\UserCreateValidator as UserCreateValidator;
use Lib\Validation\UserCreateWithoutPassValidator as UserCreateWithoutPassValidator;
use Lib\Gestion\UserGestion as UserGestion;

class AuthController extends BaseController {

    protected $login_validation;
    protected $create_validation;
	protected $createWithoutPass_validation;
	protected $user_gestion;

	public function __construct(
		UserLoginValidator $login_validation,
		UserCreateValidator $create_validation,
		UserCreateWithoutPassValidator $createWithoutPass_validation,
		UserGestion $user_gestion
		)
	{
		parent::__construct();
		$this->beforeFilter('guest', array('except' => 'getLogout'));
		$this->login_validation = $login_validation;
		$this->create_validation = $create_validation;
		$this->createWithoutPass_validation = $createWithoutPass_validation;
		$this->user_gestion = $user_gestion;
	}

	public function getLogin()
	{
		if (Auth::check()) {
			return Redirect::intended('public');
		}
		if (null !== Input::get('forgot')) { // Page de mdp oublier
		  	return $this->getRemind();
		}
		if (null !==Input::get('reset')) {
			return $this->getReset($token = null);
		}
		if (null !==Input::get('register')) {
			return $this->getRegister();
		}
		return View::make('connection.login', Lang::get('login.login'));
	}


	// Login
	public function postLogin()
	{
		if ($this->login_validation->fails()) {
		  return Redirect::to('/')
		  ->withErrors($this->login_validation->errors())
		  ->withInput();
		} else {
			$user = array(
				'email' => Input::get('email'), 
				'password' => Input::get('password')
			);
			if(Auth::attempt($user, Input::get('souvenir'))) {
				$mail = Input::get('email');
				Session::put('email', Input::get('email'));
				Session::put('role',  helpers::getRole(Input::get('email')));
				return Redirect::intended('public')
					->with('status', Lang::get('login.connection'));
			}
		    return Redirect::to('/')
		    ->with('pass', Lang::get('login.password'))
		    ->withInput();
		}
	}

	// this function is used to be login with a generate password when register
	public function postLogin_($pswd)
	{
		if ($this->login_validation->fails()) {
		  return Redirect::to('/')
		  ->withErrors($this->login_validation->errors())
		  ->withInput();
		} else {
			$user = array(
					'email' => Input::get('email'), 
					'password' => $pswd
			);

			if(Auth::attempt($user, Input::get('souvenir'))) {
				$mail = Input::get('email');
				$results = $this->user_gestion->getRole($mail);
				Session::put('email', Input::get('email'));
				Session::put('role',  helpers::getRole(Input::get('email')));
				return Redirect::intended('public')
				->with('status', Lang::get('login.connection'));
			}
		    return Redirect::to('/')
		    ->with('pass', Lang::get('login.password'))
		    ->withInput();
		}
	}

	//disconnect 
	public function getLogout()
	{
		if (Auth::check()) {
			Auth::logout();
			Session::forget('role', 'user');
			return Redirect::route('connection.login')
			->with('status', Lang::get('login.disconnect'));
		}
		return Redirect::back();
	}

	// Envoie de mail lors de l'incription avec le mdp de l'utilisateur
	public function registerMail($pswd)
	{
		Mail::send('emails.auth.register',array ('pswd' => $pswd, 'email' => Input::get('email')), function($m)
			{
				$m->to(Input::get('email'), Input::get('email') )->subject(Lang::get('reminders.subjectRegisterMail'));
			});
	}

	// View Register
	public function getRegister()
	{
		return View::make('connection.register', Lang::get('login.register'));
	}

	// Inscription à l'application, deux posibilitées
	// L'utilisateur n'a renseigné que l'email (1er partie)
	// L'utilisateur a renseigné l'email et le mot de passe (2é partie)
	public function postRegister()
	{
		if (Input::get('password') == null){	// Without Password
			$pswd = strstr(Input::get('email'), '@', true).''.str_random(7);

			if ($this->createWithoutPass_validation->fails()) {
				return Redirect::back()
				->withInput()
				->withErrors($this->createWithoutPass_validation->errors());
			} else {
				$this->registerMail($pswd); // Appelle de la fonction qui génére automatiquement un email lors de l'inscription
				$this->user_gestion->store_($pswd); // Enregistre l'utilisateur
				$this->postLogin_($pswd); // Connecte l'utilisateur
				return Redirect::route('admin.index')
				->with('status', Lang::get('login.register_info'));
			}		


		// With password
		} else { 
			if ($this->create_validation->fails()) {
				return Redirect::back()
				->withInput()
				->withErrors($this->create_validation->errors());
			} else {
				$this->registerMail(Input::get('password'));
				$this->user_gestion->store();
				$this->postLogin();
				return Redirect::route('admin.index')
				->with('status', Lang::get('login.register_info'));
			}		
		}
		
	}
	// REMINDER 

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getRemind()
	{
		return View::make('connection.remind', Lang::get('reminders.forgot'));
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind()
	{
		switch ($response = Password::remind(Input::only('email'), function($message)
			{
				$message->subject( Lang::get('reminders.subjectResetMail')); // Subject E-mail
			}))
			
		{
			case Password::INVALID_USER:
				return Redirect::back()->with('error', Lang::get($response));

			case Password::REMINDER_SENT:
				return Redirect::back()->with('status', Lang::get($response));
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{	
		$token = Input::get('reset');
		if (is_null($token)) App::abort(404);

		return View::make('connection.reset')->with('token', $token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{

		Password::validator(function($credentials)
		{
		    return strlen($credentials['password']) >= 8;
		});
		
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

			$user->save();
		});

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return Redirect::back()->with('error', Lang::get($response));

			case Password::PASSWORD_RESET:
				return Redirect::to('/')->with('status' , Lang::get($response));
		}

	}


}