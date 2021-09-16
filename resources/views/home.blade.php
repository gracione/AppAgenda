<?php 
$funcionarios=session('funcionarios');
$agendas=session('agendas');
function nomeFuncionario($id){
    foreach ( session('funcionarios')->where('id','=',$id) as $key => $value) {
        return $value->nome;
    }
}
function formatoData($data){
    $arrayMes = array(1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro');
    $data = explode(' ',$data);
    $formato=explode('-',$data[0]);
    $data[0]=$formato[2]." de ".$arrayMes[intVal($formato[1])]." ".$formato[0];

    return $data[0];
}
function formatoHorario($data){
    $data = explode(' ',$data);
    $data = explode(':',$data[1]);
    $data = $data[0].":".$data[1];
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="440.4">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Salao</title>
    <style>
        .rosa{
            background-color: #DA70D6;
            color: white;
        }
        .horarios{
            width: 100%;
            margin-top: 1%;
            background-color: #8ad4ff;
            color: black;
            opacity: 0.9;
            text-align: center;
        }
        @media (min-width: 0px) {
            .cart{
                width: 100%;
            }

            .home #agenda{
                width: 98%;
                margin-left: 1%;
            }
            .home #horarios{
                width: 98%;
                margin-left: 1%;
            }
            .home .data{
                width: 100%;
            }
        }
    
        @media (min-width: 992px) {
            .home #agenda{
                width: 45%;
                margin-left: 1%;
            }
            .home #horarios{
                width: 50%;
                margin-left: 3%;
            }
    
        }
    </style>
</head>
<body>
    <nav class="text-white navbar navbar-expand-md navbar-primary alert rosa">
            <a class="text-white w-50 nav-link navbar-brand" style="font-style: italic;" href="{{ route('inicial') }}">
                Estudio Hair alize
            </a>
            <button class="col-2 navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <img width="80%" src="https://image.flaticon.com/icons/png/512/55/55003.png" alt="">
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="border text-white nav-item nav-link">
                        <b>
                            {{ session('nome') }}
                        </b>
                    </li>
                    <li class="ml-5 nav-item nav-link">
                        <a class="text-white" href="{{ route('sair') }}">Sair </a>
                    </li>
                </ul>
            </div>
    </nav>
    <div class="d-flex justify-content-center"  >

        <div class="row container home">
            <!--funcionarios-->
            <div class="mt-1 alert alert-primary" id="agenda" >
                <div class="h4 row m-0 mt-2 mb-2 d-flex justify-content-center " >
                    Escolha o funcionario
                </div>
                <form action="{{ route('funcionario') }}"  method="get">
                    @csrf

                    @foreach ($funcionarios as $item)

                        <div class="" >
                            <input class="d-none" type="radio" name="funcionario" id="{{ $item->id }}" value="{{ $item->id }}" >
                            <label onclick="selecionar({{ $item->id }})" for="{{ $item->id }}" class="alert d-flex justify-content-center rosa s {{ $item->id }} ">
                            <h2>
                                {{ $item->nome }}
                            </h2>
                            </label>
                        </div>

                    @endforeach

                    <button class="float-right btn rosa" >Agendar>></button>
                </form>
            </div>
            <!--agenda-->
            <div class="mt-1 card alert-primary" id="horarios" >
                @foreach ($agendas as $item)
                <!--cartao-->
                <div  class="card m-0 cart {{ $item->nome }} mt-1" >
                    <!--data-->
                    <div class="card w-100 rosa d-flex justify-content-center" style="height: 30px;" > 
                        <b>
                            {{ formatoData($item->data) }}
                        </b>
                    </div>
                    <!--informacoes-->
                    <div class="row m-0 bg-light" >
                        <!--hora-->
                        <div class="" style="width: 35%;" >
                            <div  class="" style="width: 100%;height:70%;">
                                <h1 class="m-0" >
                                    {{ formatoHorario($item->data) }}
                                </h1>
                            </div>
                        </div>
                        <!--descricao-->
                        <div class="" style="width: 65%;" >
                            <h6>
                                <b>Funcionario: </b>{{ nomeFuncionario($item->idFuncionario) }}
                            </h6>
                            <b >Cliente:</b>{{ $item->nome }}
                            <br>
                            <b>Descricao:</b>{{ $item->descricao }}
                            <br>
                            <b>Tipo:</b>{{ $item->tipo }}
                            <a href="https://web.whatsapp.com/send?phone={{ $item->telefone }}" style="width: 100%; height:45px;" class="mb-1 row m-0 card alert-success " >
                                <div style="width: 20%;" class="">
                                    <img width="60%" class="" src="https://logodownload.org/wp-content/uploads/2015/04/whatsapp-logo-1.png" alt="">
                                </div>
                                <div class="mt-2" style="width: 80%;" >
                                    <b >{{ $item->telefone }}</b>
                                </div>
                            </a>
                        </div>
                        <!--cancelar-->
                        <div style="width: 100%;height:20%;" class="btn btn-outline-info">
                            <a style="width: 100%;height:100%;" class="text-info" href="{{ route('apagar',['id' => $item->id ]) }}">Cancelar</a>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
        </div>
    </div>
</body>
</html>

<script>
    let corte= document.getElementById('corte');
    let pintura= document.getElementById('pintura');
    let tranca= document.getElementById('tranca');
    let agenda = document.getElementById('agenda');
    agenda.style.display="block";
    corte.style.display="none";
    pintura.style.display="none";
    tranca.style.display="none";
    
    function cortes(){
        agenda.style.display="none";
        tranca.style.display="none";
        pintura.style.display="none";
        corte.style.display="inline";
    }
    function pinturas(){
        agenda.style.display="none";
        corte.style.display="none";
        tranca.style.display="none";
        pintura.style.display="inline";
    }
    function trancas(){
        agenda.style.display="none";
        corte.style.display="none";
        pintura.style.display="none";
        tranca.style.display="inline";
    }
</script>
<script>
    let selecionar = (id)=>{
        let elementos = document.getElementsByClassName('s');

        for (let i = 0 ;i < elementos.length; i++) {
                elementos[i].style.background="#DA70D6";
                document.getElementsByClassName(id)[0].style.background="#902bd3";          
        }
    }
</script>