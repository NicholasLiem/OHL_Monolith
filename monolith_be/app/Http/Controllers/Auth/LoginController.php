<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            $credentials['username'] = $credentials['email'];
            unset($credentials['email']);
        }

        if (Auth::attempt($credentials))
        {
            $request->session()->put('username', Auth::user()->username);
            return redirect()->intended('dashboard');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials.']);
        }
    }
}
