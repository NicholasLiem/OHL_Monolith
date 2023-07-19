<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;
use Illuminate\Support\Facades\Cookie;
use App\Helpers\ResponseUtils;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $value = Cookie::get('jwt_token');
            if ($value) {
                $user = auth()->setToken($value)->user();
                if (!$user) {
                    ResponseUtils::flashError('You are not logged in');
                    return redirect('/welcome');
                }
                $request->attributes->add(['username' => $user['username']]);
            } else {
                ResponseUtils::flashError('You are not logged in');
                return redirect('/welcome');
            }
        } catch (UserNotDefinedException $e) {
            ResponseUtils::flashError('You are not logged in');
            return redirect('/welcome');
        }
        return $next($request);
    }
}
