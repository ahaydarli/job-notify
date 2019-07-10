<?php
namespace App\Http\Middleware;


use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Auth;


class AuthMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('Authorization'); // get token from request header

        if(!$token) {

            // Unauthorized response if token not there

            return response()->json([
                'status' => 401,
                'error' => 'Token required.'
            ], 401);
        }

        try {
            $token = explode(' ',$request->header('Authorization'));
            $credentials = JWT::decode($token[1], env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {

            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);

        } catch(Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 400);
        }
        $user = User::find($credentials->sub);
        if(!empty($user)){
            $request->auth = $user;
        }else{
            return response()->json([
                'error' => 'Provided token is invalid.'
            ], 400);
        }

        return $next($request);
    }
}
