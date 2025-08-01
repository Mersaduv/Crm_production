<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SupportMiddleware
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
        if (!auth()->check() || auth()->user()->role !== 'support') {
            abort(404);
        }

        return $next($request);
    }
}
