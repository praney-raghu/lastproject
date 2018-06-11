<?php

namespace Ssntpl\Neev\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Ssntpl\Neev\Facades\Neev;
use Illuminate\Support\Facades\Password;
use Ssntpl\Neev\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected function redirectTo() {
        return route('user.home');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('neev::auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        // Validate request.
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        // Get the user associated with this email and current reseller. If not found return with error.
        $user = Neev::getUser($request->input('email'));
        if (is_null($user)) {
            return $this->sendResetFailedResponse($request, Password::INVALID_USER);
        }

        // Validate the token against this user.
        if (!$user->verifyPasswordResetToken($request->input('token'))) {
            return $this->sendResetFailedResponse($request, Password::INVALID_TOKEN);
        }

        // Update the password on actual user model and persist it to the database.
        $this->resetPassword($user, $request->input('password'));

        // Delete password reset token.
        $user->deletePasswordResetToken();

        // Password was successfully reset, we will redirect the user to the dashboard.
        return $this->sendResetResponse(Password::PASSWORD_RESET);
    }
}
