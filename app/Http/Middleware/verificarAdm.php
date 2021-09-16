<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class verificarAdm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $req, Closure $next)
    {
        if($req->email=="adm@gmail.com" && $req->password=="123"){
            session(['id' => 1]);
            return redirect('/adm');
    }
        return $next($req);
    }
}
