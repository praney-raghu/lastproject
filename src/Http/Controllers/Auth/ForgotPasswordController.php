<?php

namespace Ssntpl\Neev\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Ssntpl\Neev\Facades\Neev;
use Illuminate\Support\Facades\Password;
use Ssntpl\Neev\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validate request if it contains a proper email or not.
        $this->validateEmail($request);

        // Get the user associated with this email and current reseller. If not found return with error.
        $user = Neev::getUser($request->input('email'));
        if (is_null($user)) {
            return $this->sendResetLinkFailedResponse($request, Password::INVALID_USER);
        }

        // Generate a new Password Reset Token and send it to the user.
        $user->sendPasswordResetNotification($user->createPasswordResetToken());

        // Notify the user about the sent password reset link.
        return $this->sendResetLinkResponse(Password::RESET_LINK_SENT);
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('neev::auth.passwords.email');
    }
}
