<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use App\Helpers\ResponseUtils;

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
    
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                ResponseUtils::flashError('Invalid credentials.');
                return redirect()->back();
            }

        } catch (JWTException $e) {
            ResponseUtils::flashError('Could not create token.');
            return redirect()->back();
        }

        ResponseUtils::flashSuccess('Login successful.');
        return redirect('/dashboard')->withCookie(cookie('jwt_token', $token, 60));
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function self()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return ResponseUtils::errorResponse('User not found.', 404);
            }
            return ResponseUtils::successResponse('User found.', $user);
        } catch (Exception $e) {
            return ResponseUtils::errorResponse($e->getMessage(), 500);
        }
    }

}
