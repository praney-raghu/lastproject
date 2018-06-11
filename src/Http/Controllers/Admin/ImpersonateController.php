<?php

namespace Ssntpl\Neev\Http\Controllers\Admin;

use Ssntpl\Neev\Models\User;
use Illuminate\Support\Facades\Auth;
use Ssntpl\Neev\Http\Controllers\Controller;

class ImpersonateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'permission:impersonate']);
    }

    public function impersonateUser(User $user)
    {
        // Verify if the user is a sibling of admin
        if (Auth::guard('admin')->user()->isSibling($user)) {
            Auth::guard('web')->login($user);
            return redirect()->route('user.home');
        } else {
            // Admin can't impersonate users of different organisation.
            return redirect()->back();
        }
    }

    public function impersonateGuest()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }

    public function stopImpersonation()
    {
        Auth::guard('web')->login(Auth::guard('admin')->user());
        return redirect()->route('admin.home');
    }
}
