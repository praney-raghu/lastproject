<?php

namespace Ssntpl\Neev\Http\Controllers\Auth;

use Auth;
use Neev;
use Illuminate\Http\Request;
use Ssntpl\Neev\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     */
    protected function redirectTo() {
        return route('organisation.home');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('neev::auth.login');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials['owner_id'] = (Neev::organisation()) ? Neev::organisation()->getKey() : null;

        $login_success = $this->guard()->attempt($credentials, $request->filled('remember'));

        if ($login_success) {
            $user = $this->guard()->user();

            if ($user->isAdmin()) {
                // Login admin guard if user has access to any admin role or privilege.
                Auth::guard('admin')->login($user, $request->filled('remember'));
            }
        }
        return $login_success;
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }
}
