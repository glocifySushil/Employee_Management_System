<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class adminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         if(Auth::guard('api')->check() && in_array(Auth::guard('api')->user()->role_id, Role::Admin)){

                return $next($request);
        }
        else{

            return response()->json(['error' => 'Token is invalid or You have not permission to access this page'], 403);
        }

    }
}
