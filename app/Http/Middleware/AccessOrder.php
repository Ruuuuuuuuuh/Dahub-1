<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccessOrder
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
        $accessUser = \App\Models\Order::find($request->route('id'))->first()->user();
        if (!\Auth::user()->id == $accessUser->id) {
            throw new Exception("Access denied", 403);
        }
        return $next($request);
    }
}
