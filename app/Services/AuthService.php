<?php 

namespace App\Services;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function doLogin($request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $remember_me = $request->has('remember_me') ? true : false;

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me)) {
            $user = Auth::user();
            return true;
        } else {
            return false;
        }
    }
    public function doLogout($request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
