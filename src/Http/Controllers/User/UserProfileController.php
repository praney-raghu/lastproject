<?php

namespace Ssntpl\Neev\Http\Controllers\User;

use Ssntpl\Neev\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class UserProfileController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Viewing the user' profile.
     *
     * @var string $profile
     */
    protected function profile()
    {
        $user = Auth::getUser();
        
        return view('neev::user.profile', compact('user'));
    }

    /**
     * @param Request $request
     * @return 
     */
    protected function editProfile(Request $request)
    {
        $user = Auth::getUser();

        $validatedData = $request->validate([
        'newName' => 'required|max:255',
        'newEmail' => 'required'
        ]);

        $user->name = $request->get('newName');
        $user->email = $request->get('newEmail');
        $user->save();
        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
        //return view('neev::user.profile', compact('user'));
    }
}
