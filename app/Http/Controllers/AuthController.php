<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        $setting = Setting::init();
        return view('auth.login', compact('setting'));
    }

    public function loginProcess(Request $request){
        $attempt = Auth::attempt([
            'email'  => $request->email,
            'password'  => $request->password,
            'is_active'  => 1,
        ]);
        if ($attempt){
            $request->session()->regenerate();
            return redirect()->intended();
        } else {
            return redirect('login')->with('fail', 'email / password salah.');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

}
