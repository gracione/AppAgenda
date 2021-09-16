<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\usuarios;
use App\Models\funcionarios;
use App\Models\agendas;
use App\Models\tratamentos;

use Auth;
use Hamcrest\DiagnosingMatcher;

class ControllerUser extends Controller
{
    //

    public function cadastrar(Request $req){
        usuarios::create([
            'email' => $req->email ,
            'senha' => $req->password ,
            'nome' => $req->nome,
            'telefone' => $req->telefone ,
        ]);
        //efetua login pos cadastro
        foreach (usuarios::all() as $key => $value) {
            if ($req->email == $value->email && $req->password == $value->senha) {
                session(['id' => $value->id]);
                session(['nome' => $value->nome]);
                session(['telefone' => $value->telefone]);
                session(['ano' => intVal(date('Y'))]);
                session(['mes' => intVal(date('m'))]);
                session(['mesInvisivel' => 0]);
                session(['funcionarios' => funcionarios::all()]);
                session(['agendas' => agendas::all()->where('idCliente','=',$value->id)]);

                return redirect('/home');
                
            }
        }
        return redirect('/');

    }
    public function logar(Request $req){
        //verificar se o usuario esta cadastrado
        foreach (usuarios::all() as $key => $value) {
            if ($req->email == $value->email && $req->password == $value->senha) {
                session(['id' => $value->id]);
                session(['nome' => $value->nome]);
                session(['telefone' => $value->telefone]);
                session(['ano' => intVal(date('Y'))]);
                session(['mes' => intVal(date('m'))]);
                session(['mesInvisivel' => 0]);
                session(['funcionarios' => funcionarios::all()]);
                session(['agendas' => agendas::all()->where('idCliente','=',$value->id)]);
                
                return redirect('/home');
            }
        }
        return redirect('/');
    }
    public function marcarHorario(Request $req){
        //se existir sessao nome ela vai ser atribuida ao nome
        $nome = session('novoNome')!=null ? session('novoNome') : session('nome');
        
        //formatar date
        $data=explode('/',$req->horario);        
        $data = $req->ano."-".$req->mes."-".$data[1]." ".$data[0];
        

        agendas::create([
            'idCliente' => session('id') ,
            'idFuncionario' => $req->funcionario ,
            'tipo' => $req->tipo,
            'data' => $data ,
            'descricao' => $req->descricao ,
            'nome' => $nome ,
            'telefone' =>  session('telefone') ,
        ]);
        return redirect('/home');

    }
    public function apagar($id){
        $agenda = agendas::findOrFail($id);
        $agenda->delete();
        return redirect('/home');
    }
    
    public function adicionarFuncionario(Request $req){
        funcionarios::create([
            'nome'=> $req->input('nome'),
            'email'=> '',
            'senha'=> '',
            'numero'=> '',
            'tipo'=> '',
        ]);
        return redirect('/adm');
    }
    public function adicionarTratamento(Request $req){
        tratamentos::create([
            'nome'=> $req->input('nome'),
            'valor'=> $req->input('valor'),
        ]);
        return redirect('/adm');
    }
    public function alterarTratamento(Request $req,$id){
        $tratamento = tratamentos::findOrFail($id);
        $tratamento->update([
            'nome'=> $req->input('nome'),
            'valor'=> $req->input('valor'),
        ]);
        return redirect('/adm');

    }
    public function removerTratamento(Request $req,$id){
        $tratamento = tratamentos::findOrFail($id);
        $tratamento->delete();
        return redirect('/adm');
    }
    public function removerFuncionario(Request $req,$id){
        $tratamento = funcionarios::findOrFail($id);
        $tratamento->delete();
        return redirect('/adm');
    }

}
