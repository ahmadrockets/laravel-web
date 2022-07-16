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
    public function doRegister(Request $request)
    {
        try {
            $this->authService->doRegister($request);
            return redirect('/login')->withSuccess('Success register user, please verify your email');;
        } catch (\Throwable $th) {
            return redirect('/register')->withErrors('Oops! something went wrong | '.$th->getMessage());;
        }
    }
    public function verifyAccount(Request $request, $token)
    {
        try {
            $verifyUser = $this->authService->doVerifyUser($token);
            return redirect('/login')->withSuccess($verifyUser);;
        } catch (\Throwable $th) {
            return redirect('/login')->withErrors('Oops! something went wrong | ' . $th->getMessage());;
        }
    }
    public function forgotpassword()
    {
        return view('auth.forgotpassword');
    }
    
}
