<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckAuth
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

        if(!Auth::check())
        {
            $url = config('backpack.base.route_prefix').'/login';
            return redirect($url);
        }

        return $next($request);
    }
}
