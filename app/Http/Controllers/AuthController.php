<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mews\Captcha\Facades\Captcha;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha', // CAPTCHA validation rule
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
          //  dd($credentials);
            // Authentication passed...
            return redirect()->intended('dashboard');
        }

        return redirect()->back()->with('error', 'Invalid email, password, or captcha');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
