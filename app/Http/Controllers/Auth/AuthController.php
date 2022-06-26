<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        if(Auth::check()){
            return redirect('/');
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        if($this->authService->doLogin($request)){
            return redirect('/')->withSuccess('You have successfully logged in');
        }else{
            return back()->withErrors('Opps! You have entered invalid credentials');
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authService->doLogout($request);
            return redirect('/login')->withSuccess('You have successfully logged out');;
        } catch (\Throwable $th) {
            return redirect('/')->withErrors('Opps! something went wrong');
        }
    }

    public function register()
    {
        return view('auth.register');
    }
    public function forgotpassword()
    {
        return view('auth.forgotpassword');
    }
    
}
