<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ProtectApiRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->path() === 'api/admin_login'){

            \Log::info($request->path());
            return $next($request);
        }

        if(!Auth::check()){
            return response()->json([
                'msg' => 'You are not authorized!'
            ], 403);
        }

        $user = Auth::user();
        if($user->userType == 'User'){

            return response()->json([
                'msg' => 'You are not authorized!'
            ], 403);
        }

        return $next($request);
    }
}
