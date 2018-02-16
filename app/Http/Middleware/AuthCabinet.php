<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthCabinet
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
        if (Auth::guest()) {
            return redirect()->back();
        }

        return $next($request);
    }
}
