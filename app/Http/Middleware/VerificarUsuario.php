<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\usuarios;
use App\Models\funcionarios;
use App\Models\agendas;

class VerificarUsuario
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
        foreach (usuarios::all() as $key => $value) {
            if ($req->email == $value->email && $req->password == $value->senha) {
                return redirect('/');
            }
        }
        return $next($req);
    }
}
