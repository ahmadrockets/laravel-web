<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    private $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        if($this->authService->doLogin($request)){
            echo "masuk";
        }else{
            return back()->withErrors([
                'message' => ['The provided password does not match our records.']
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authService->doLogout($request);
            return redirect('/login');
        } catch (\Throwable $th) {
            return redirect('/');
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
