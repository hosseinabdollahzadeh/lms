<?php

namespace Abd\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StoreUserIp
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
        if(auth()->check() && auth()->user()->ip != $request->ip()){
            auth()->user()->ip = $request->ip();
            auth()->user()->save();
        }
        return $next($request);
    }
}
