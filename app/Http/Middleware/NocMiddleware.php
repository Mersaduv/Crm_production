<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NocMiddleware
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
        if (!auth()->check() || auth()->user()->role !== 'noc') {
            abort(404);
        }

        return $next($request);
    }
}
