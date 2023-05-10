<?php

namespace App\Http\Middleware;

use App\Helpers\JwtHelper;
use Closure;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ValidateJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!empty($request->bearerToken())) {
            try {
                $decode= JwtHelper::decode($request->bearerToken());
                Auth::onceUsingId($decode->id);
                return $next($request);
            }catch (ExpiredException $exp) {
                return response("token Expired", 401);
            } catch (\Throwable $th) {
                return response("auth failed", 401);
            }
        }

        return response("auth failed", 401);
        
    }
}
