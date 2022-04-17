<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsGateManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::check()) {
            if (\Auth::user()->roles == 'admin' || \Auth::user()->roles == 'gate_manager') {
                return $next($request);
            }
        }

        return redirect('/');
    }
}
