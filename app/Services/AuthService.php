<?php 

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserVerify;
use App\Models\UserProfile;
use Mail;
use App\Mail\SignupMail;

use function PHPUnit\Framework\throwException;

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
    public function doRegister($request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'country' => 'required',
            'province' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'agree' => 'required',
        ]);
        $dataReq = $request->all();
        try {
            DB::beginTransaction();
            $userCreated = User::create([
                'name' => $dataReq['first_name']." ".$dataReq['last_name'],
                'email' => $dataReq['email'],
                'password' => Hash::make($dataReq['password'])
            ]);
            $token = Str::random(64);
            UserVerify::create([
                'user_id' => $userCreated->id,
                'token' => $token
            ]);
            UserProfile::create([
                'user_id'=> $userCreated->id,
                'country_id'=> $dataReq['country'],
                'province_id'=> $dataReq['province'],
                'city'=> $dataReq['city'],
                'postal_code'=> $dataReq['postal_code'],
            ]);
            $signUpEmail = new SignupMail();
            $signUpEmail->name = $userCreated->name;
            $signUpEmail->email = $userCreated->email;
            $signUpEmail->token = $token;
            Mail::to($userCreated->email)->send($signUpEmail);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            throw new \ErrorException("Error signup process | ".$th->getMessage());
            DB::rollback();
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
