<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roleId)
    {

        foreach($roleId as $item){
             // admin only
            if(Auth::check() && Auth::user()->roleId == $item){
                return $next($request);
            }
        }
        // // admin only
        // if(Auth::check() && Auth::user()->roleId == $roleId[0]){
        //     return $next($request);
        // }
        // // member only
        // else if(Auth::check() && Auth::user()->roleId == $roleId[0]){
        //     return $next($request);
        // }
        // // member and admin
        // else if(Auth::check() && Auth::user()->roleId == $roleId[1]){
        //     return $next($request);
        // }
        abort(403);

        return $next($request);
    }
}
