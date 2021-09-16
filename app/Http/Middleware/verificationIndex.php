<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class verificationIndex
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
        if(session('id')!=null){
            if(session('id')==1){
                //se o usuario e um adm
                echo "ool";
                return redirect('/adm');
                }else{
                    //se o usuario não e adm
                    return redirect('/home');
                }
            }
        return $next($request);
    }
}
