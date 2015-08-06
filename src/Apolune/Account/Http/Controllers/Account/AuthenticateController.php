<?php

namespace Apolune\Account\Http\Controllers\Account;

use Illuminate\Contracts\Auth\Guard;
use Apolune\Core\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Exception\HttpResponseException;
use Apolune\Account\Http\Requests\Account\AuthenticateRequest;

class AuthenticateController extends Controller
{
    use ThrottlesLogins;
    
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;

        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return '/account/login';
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return 'name';
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function form()
    {
        return view('theme::account.auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Apolune\Account\Http\Requests\Account\AuthenticateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(AuthenticateRequest $request)
    {
        $credentials = $request->only('name', 'password');

        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        if (! $this->auth->attempt($credentials, $request->has('remember'))) {
            $this->incrementLoginAttempts($request);

            throw new HttpResponseException($request->response([
                'name' => trans('theme::account.login.form.error'),
            ]));
        }

        $this->clearLoginAttempts($request);

        return redirect()->intended('/account');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function logout()
    {
        if (! $this->auth->check()) {
            return redirect('/account');
        }

        $this->auth->logout();

        return view('theme::account.auth.logout');
    }
}