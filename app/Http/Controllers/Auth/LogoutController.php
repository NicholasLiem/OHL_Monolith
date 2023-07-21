<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;
use App\Helpers\ResponseUtils;

class LogoutController extends Controller
{
    public function logout()
    {
        $token = Cookie::get('jwt_token');

        if ($token) {
            JWTAuth::setToken($token)->invalidate();
        } else {
            ResponseUtils::flashError('Could not find token.');
        }

        Cookie::queue(Cookie::forget('jwt_token'));

        ResponseUtils::flashSuccess('Successfully logged out.');
        return view('welcome');
    }
}
