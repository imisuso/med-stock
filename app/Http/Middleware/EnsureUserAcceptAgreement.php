<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserAcceptAgreement
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

        if(!$request->user() 
            || !$request->user()->needAcceptAgreement()
            || $request->routeIs('agreement') 
            || $request->routeIs('logout')
            || $request->routeIs('accept-agreement'))   
        {
            return $next($request);
        }
        return redirect('agreement');
    }
}
