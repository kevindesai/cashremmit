<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Illuminate\Support\Facades\Config;
Config::set('auth.providers.users.table', 'users');
class authJWT {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        try {
            $user = JWTAuth::toUser($request->input('token'));
        } catch (Exception $e) {
//            print_r($e->getMessage());
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => -1, 'error' => 'Token is Invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status' => -1, 'error' => 'Token is Expired']);
            } else {
                return response()->json(['status' => -1, 'error' => 'Something is wrong']);
            }
        }
        return $next($request);
    }

}
