<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerUser;
use App\Http\Controllers\FrontEnd;
use App\Mail\OrderShipped;
use Illuminate\Queue\Connectors\RedisConnector;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//1 tela De Login
Route::get('/',[FrontEnd::class,'index'])->middleware('verificationIndex');

//1 tela De Cadastro
Route::get('/cadastro',[FrontEnd::class,'cadastro'])->middleware('verificationIndex')->name('cadastro');

//2 efetuar login
Route::post('/',[ControllerUser::class ,'logar'])->middleware('verificarAdm')->name('logar');

//2 verifica se existe algum usuario com o mesmo email e senha e efetua o cadastro
Route::post('/cadastro',[ControllerUser::class ,'cadastrar'])->middleware('verificacao')->name('efetuarCadastro');


//3 home
Route::get('/home',[FrontEnd::class ,'home'])->middleware('userVerification');

//3 adm
Route::get('/adm',[FrontEnd::class,'adm'])->middleware('admVerification');


//4 ea mesma tela para adm ou user
Route::get('/calendar',[FrontEnd::class,'calendar'])->name('funcionario');
//Route::post('/calendar',[ControllerUser::class,'calendar']);

//6 sair da pagina
Route::get('/sair',function(){
    session(['id' => null]);
    session(['email' => null]);
    session(['telefone' => null]);
    session(['nome' => null]);
    session(['novoNome'=>null]);
    return redirect('/home');
})->name('sair');

//5 apagar horario
Route::get('/home/{id}',[ControllerUser::class,'apagar'])->name('apagar');



//funcoes de manipulação do calendario---------------------------------------------------
Route::get('/calendario/{add}',function($add){
    session(['mes'=> session('mes')+1 ]);
    session(['funcionario'=> $add]);
    return redirect('/calendar');
})->name('proximoMes');

Route::get('/calendarioAntes/{add}',function($add){
    session(['mes'=> session('mes')-1 ]);
    session(['funcionario'=> $add]);
    return redirect('/calendar');
})->name('MesAnterior');

//--marcar horario----------------------------------------------------------------------
Route::post('/calendar',[ControllerUser::class,'marcarHorario'])->name('marcarHorario');

// link para ir para tela original------------------------------------------------------
Route::get('/inicial',function(){
    return session('id')==1? redirect('/adm'): redirect('/home');
})->name('inicial');


//funcoes para adm--------------------------------------------------------------------------------------------------

//adicionar funcionario
Route::post('/adicionarFuncionario',[ControllerUser::class,'adicionarFuncionario'])->name('adicionarFuncionario');
//remover funcionario
Route::get('/removerFuncionario/{id}',[ControllerUser::class,'removerFuncionario'])->name('removerFuncionario');
//adicionar tratamento capilar
Route::post('/adicionar',[ControllerUser::class,'adicionarTratamento'])->name('adicionarTratamento');
//remover tratamento capilar
Route::get('/removerTratamento/{id}',[ControllerUser::class,'removerTratamento'])->name('removerTratamento');
//alterar tratamento capilar
Route::post('/alterarTratamento/{id}',[ControllerUser::class,'alterarTratamento'])->name('alterarTratamento');
