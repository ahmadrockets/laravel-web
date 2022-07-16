<?php 

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserVerify;
use App\Models\UserProfile;
use App\Models\PasswordReset;
use Mail;
use App\Mail\SignupMail;
use App\Mail\ResetPasswordMail;

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
            DB::rollback();
            throw new \ErrorException("Error signup process | ".$th->getMessage());
            return false;
        }
    }
    public function doVerifyUser($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
        $message = 'Sorry your email cannot be identified.';
        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->email_verified_at = date('Y-m-d H:i:s');
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
            return $message;
        }else{
            throw new \ErrorException($message);
        }
    }

    public function doSendEmailForgotPassword($request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        try {
            DB::beginTransaction();
            $token = Str::random(64);
            $passwordReset = PasswordReset::where('email', $request->input('email'))->first();
            if (!is_null($passwordReset)) {
                PasswordReset::where('email', $request->input('email'))->update(['token' => $token]);
            }else{
                $passwordReset = PasswordReset::create([
                    'email' => $request->input('email'),
                    'token' => $token,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
            $resetPasswordMail = new ResetPasswordMail();
            $resetPasswordMail->email = $passwordReset->email;
            $resetPasswordMail->token = $token;
            Mail::to($resetPasswordMail->email)->send($resetPasswordMail);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            throw new \ErrorException("Error signup process | " . $th->getMessage());
            return false;
        }
    }

    public function getResetPassData($token)
    {
        $verifyUser = PasswordReset::where('token', $token)->first();
        if (!is_null($verifyUser)) {
            $user = User::where('email', $verifyUser->email)->first();
            return $user;
        } else {
            throw new \ErrorException('Sorry your link is not valid, please check again.');
        }
    }

    public function doResetPassword($request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
            'token' => 'required',
        ]);
        try {
            $verifyUser = PasswordReset::where('token', $request->input('token'))->first();
            if (!is_null($verifyUser)) {
                DB::beginTransaction();
                $user = User::where('email', $verifyUser->email)->first();
                $user->password = Hash::make($request->input('password'));
                $user->save();
                DB::commit();
                return true;
            } else {
                throw new \ErrorException('Sorry your email cannot be identified.');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw new \ErrorException("Error reset password | " . $th->getMessage());
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
