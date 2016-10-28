<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectGuests
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
        //Guests are not logged it => redirect
        if (!Auth::check())
        {
            return redirect()->guest('/');
        }
        //Disabled users that were disabled should be redirected too
        $user =Auth::user();
        if ($user and !$user->enabled){
            Auth::logout();
            return redirect()->guest('/');
        }


        return $next($request);
    }
}
