<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserAuth
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
        $routeName = $request->path();

        if(!Auth::check() && (

            str_contains($routeName, 'user') == true || 
            $routeName == 'logout' || 
            str_contains($routeName, 'dashboard') == true || 
            str_contains($routeName, 'rights-management') == true || 
            str_contains($routeName, 'case-folder') == true ||
            str_contains($routeName, 'report') == true ||
            str_contains($routeName, 'maintenance') == true ||
            str_contains($routeName, 'api') == true ||
            str_contains($routeName, 'profile') == true
            
            )){

            return Redirect::to('/login');
        }

        if(Auth::check() && ($routeName == 'login')){
            return Redirect::to('/');
        }

        return $next($request);
    }
}
