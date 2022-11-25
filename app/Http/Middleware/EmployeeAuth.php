<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Models\User;
use App\Models\Role;

class EmployeeAuth
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
         if(Auth::guard('api')->check()){

            $id = Auth::guard('api')->user()->id;

            $user = User::find($id);

            $role =  $user->role_id;

            $request->merge(['role_access'=>$role]);

            return $next($request);

        }
        else{

            return response()->json(['error' => 'Token is invalid'], 401);
        }
        
    }
}
