<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserVerification
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
        //verifica se usuario existe
        if(session('id')!=null){
            //verifica se o usuario e adm
            if(session('id')==1){
                return redirect('/adm');
            }else{
                return $next($request);
            }
        }
        //se não for ele retorna para o index
        return redirect('/');
    }
}
