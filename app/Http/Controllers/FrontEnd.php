<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuarios;
use App\Models\funcionarios;
use App\Models\agendas;
use App\Models\tratamentos;


use function App\Http\Controllers\verificationValidation as ControllersVerificationValidation;



class diaMes
{
    public $dia = 0;
    public $mes = 0;
    public $horario = 0;
    function set_dia($dia)
    {
        $this->dia = $dia;
    }
    function set_mes($mes)
    {
        $this->mes = $mes;
    }
    function set_horario($horario)
    {
        $this->horario = $horario;
    }
}
function criarRelogio($inicio, $inicioAlmoco, $fimAlmoco, $fim)
{
    $vetor = array();
    $minutos = 0;
    while ($inicio <= $fim) {
        $minutos += 30;
        $aux = $inicio < 10 ? '0' : '';

        if ($minutos == 60) {
            if ($inicioAlmoco >= $inicio || $fimAlmoco <= $inicio) {
                $vetor[] = $aux . $inicio . ":30";
            }
            $inicio += 1;
            $minutos = 0;
        } else {
            if ($inicioAlmoco >= $inicio || $fimAlmoco <= $inicio) {
                $vetor[] = $aux . $inicio . ":00";
            }
        }
    }
    return $vetor;
}
function verificationValidation()
{
    //verifica se algum usuario esta logado
    if (session('id') != null) {
        if (session('id') == 1) {
            //se o usuario e um adm
            return redirect('/adm');
        } else {
            //se o usuario não e adm
            return redirect('/home');
        }
    }
}
function verificationAdm()
{

    if (session('id') == 1) {
        return redirect('/adm');
    }
    echo session('id');
    return redirect('/home');
}

class FrontEnd extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function cadastro()
    {
        return view('cadastro');
    }
    public function home()
    {
        if (session('id') == null) {
            return redirect('/');
        }
        session(['agendas' => agendas::all()->where('idCliente', '=', session('id'))]);

        return view('home');
    }
    public function adm()
    {
        echo "teste";
        print_r(agendas::all());
        session(['nome' => 'adm']);
        session(['telefone' => '+55 64 999825864']);
        session(['ano' => intVal(date('Y'))]);
        session(['mes' => intVal(date('m'))]);
        session(['mesInvisivel' => 0]);
        session(['funcionarios' => funcionarios::all()]);
        session(['agendas' => agendas::all()]);
        session(['tratamentos' => tratamentos::all()]);
        return view('adm');
        }
    public function calendar(Request $req)
    {


        $ano = session('ano');
        $mes = session('mes');

        if (!empty($req->funcionario)) {
            $funcionario = $req->funcionario;
        } else {
            $funcionario = session('funcionario');
        }

        $diasDaSemana = array('Dom' => array(), 'Seg' => array(), 'Ter' => array(), 'Qua' => array(), 'Qui' => array(), 'Sex' => array(), 'Sab' => array());
        $arrayMes = array(1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro');

        for ($i = 1; $i <= 12; $i++) {
            $arrayRetorno[$i] = array();
            for ($n = 1; $n <= cal_days_in_month(CAL_GREGORIAN, $i, $ano); $n++) {

                $dayMonth = gregoriantojd($i, $n, $ano);
                $weekMonth = substr(jddayofweek($dayMonth, 1), 0, 3);

                if ($weekMonth == 'Mun') $weekMonth = 'Mon';

                $arrayRetorno[$i][$n] = $weekMonth;
            }
        }

        foreach ($arrayRetorno[$mes] as $key => $value) {
            if ($value == 'Sun') array_push($diasDaSemana['Dom'], $key);
            if ($value == 'Mon') array_push($diasDaSemana['Seg'], $key);
            if ($value == 'Tue') array_push($diasDaSemana['Ter'], $key);
            if ($value == 'Wed') array_push($diasDaSemana['Qua'], $key);
            if ($value == 'Thu') array_push($diasDaSemana['Qui'], $key);
            if ($value == 'Fri') array_push($diasDaSemana['Sex'], $key);
            if ($value == 'Sat') array_push($diasDaSemana['Sab'], $key);

            if ($key == 1 && $value == "Mon") {
                array_unshift($diasDaSemana['Dom'], "_");
            }
            if ($key == 1 && $value == "Tue") {
                array_unshift($diasDaSemana['Dom'], "_");
                array_unshift($diasDaSemana['Seg'], "_");
            }
            if ($key == 1 && $value == "Wed") {
                array_unshift($diasDaSemana['Dom'], "_");
                array_unshift($diasDaSemana['Seg'], "_");
                array_unshift($diasDaSemana['Ter'], "_");
            }
            if ($key == 1 && $value == "Thu") {
                array_unshift($diasDaSemana['Dom'], "_");
                array_unshift($diasDaSemana['Seg'], "_");
                array_unshift($diasDaSemana['Ter'], "_");
                array_unshift($diasDaSemana['Qua'], "_");
            }
            if ($key == 1 && $value == "Fri") {
                array_unshift($diasDaSemana['Dom'], "_");
                array_unshift($diasDaSemana['Seg'], "_");
                array_unshift($diasDaSemana['Ter'], "_");
                array_unshift($diasDaSemana['Qua'], "_");
                array_unshift($diasDaSemana['Qui'], "_");
            }
            if ($key == 1 && $value == "Sat") {
                array_unshift($diasDaSemana['Dom'], "_");
                array_unshift($diasDaSemana['Seg'], "_");
                array_unshift($diasDaSemana['Ter'], "_");
                array_unshift($diasDaSemana['Qua'], "_");
                array_unshift($diasDaSemana['Qui'], "_");
                array_unshift($diasDaSemana['Sex'], "_");
            }
        }

        $horarios = agendas::all();
        session(['tratamentos' => tratamentos::all()]);
        $cont = 0;
        $diasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

        //dentro desse for tem todos os horarios de todos os dias
        //cria vetor vazio
        $Horarios = array();
        for ($dia = 0; $dia <= $diasMes; $dia++) {
            $horariosIndisponivel = array();
            $i = 0;
            foreach ($horarios as $hor) {
                $Dia = substr($hor->data, 8, -9);
                $Mes = substr($hor->data, 5, -12);
                $Funcionario = $hor->idFuncionario;
                //echo $Dia;
                //se o dia selecionado for igual o dia capiturado pelo banco de dados e o mes for igual o mes capiturado
                //pelo banco de dados e o id do funcionario selecionado for igual o capiturado do banco de dados executa
                if ($dia == $Dia && $mes == intVal($Mes)  && $Funcionario == $funcionario) {
                    $i += 1;
                    $horariosIndisponivel[$i] = new diaMes();
                    $horariosIndisponivel[$i]->set_dia($dia);
                    $horariosIndisponivel[$i]->set_mes($mes);
                    $horariosIndisponivel[$i]->set_horario(substr($hor->data, 11, -3));
                }
            }
            $Horarios[$dia] = $horariosIndisponivel;
        }
        $relogio = criarRelogio(7, 11, 13, 20);
        //se o usuario for adm
        if (session('nome') == "adm") {
            //vai criar uma sessao novo nome e atribuir o nome do req
            session(['novoNome' => $req->nome]);
        }
        return view('calendar', ['diasDaSemana' => $diasDaSemana, 'Horarios' => $Horarios, 'contador' => 0, 'relogio' => $relogio, 'mes' => $mes, 'ano' => $ano, 'funcionario' => $funcionario, 'nomeMes' => $arrayMes[$mes]]);
    }
}
