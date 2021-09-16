<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class proximoMes
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
        session(['mesInvisivel' => 1]);
        return $next($request);
    }
}
