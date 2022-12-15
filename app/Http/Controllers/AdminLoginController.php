<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminLoginController extends Controller
{
    public function admin_login()
    {

        # code...
        return view('admin.admin_login');
    }

    public function admin_authenticate(Request $request)
    {
        # code...
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $remember = $request->input('remember');
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::attempt($credentials, $remember)) {

            $user = Auth::user();
            $email_verified_at = $user->email_verified_at;

            if ($email_verified_at == null) {
                $user = User::where('email', '=', $credentials['email'])->first();
                $user->sendEmailVerificationNotification();
            }

            if ($user->role == 0) {
                return Redirect::route('admin.login')->with('error', 'incorrect credentials');
            }

            // login success
            return Redirect::route('admin.dashboard');
        }
        return Redirect::route('admin.login')->with('error', 'incorrect credentials');
    }
}
