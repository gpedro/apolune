<?php namespace Apolune\Account\Http\Controllers;

use Apolune\Account\Models\Account;
use Apolune\Core\Http\Controllers\Controller;
use Apolune\Account\Http\Requests\Auth\LoginRequest;
use Apolune\Account\Http\Requests\Auth\RegisterRequest;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Exception\HttpResponseException;

class AuthController extends Controller {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Show the application login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogin()
	{
		return view('theme::account.auth.login');
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Apolune\Account\Http\Requests\Auth\LoginRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(LoginRequest $request)
	{
		$credentials = $request->only('name', 'password');

		if ( ! $this->auth->attempt($credentials, $request->has('remember')))
		{
			throw new HttpResponseException($request->response([
				'name' => trans('theme::account.login.form.error'),
			]));
		}

		return redirect()->intended('/account');
	}

	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getRegister()
	{
		return view('theme::account.auth.register');
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Apolune\Account\Http\Requests\Auth\RegisterRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(RegisterRequest $request)
	{
		$account = Account::create([
			'name'		 => $request->get('name'),
			'email'		 => $request->get('email'),
			'password'	 => bcrypt($request->get('password')),
		]);

		$this->auth->login($account);

		return redirect('/account');
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogout()
	{
		$this->auth->logout();

		return redirect('/account/login');
	}

}
