<?php 
$funcionarios=session('funcionarios');
$agendas=session('agendas');
$tratamentos=session('tratamentos');
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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="4440.4">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Salao</title>
    <link rel="stylesheet" href="css/app.css" type="text/css">

</head>
<body>
    <!--nav-->
    <nav class="text-white navbar navbar-expand-md navbar-primary alert rosa">
            <a class="text-white w-50 nav-link navbar-brand" style="font-style: italic;" href="{{ route('inicial') }}">
                Estudio Hair alize
            </a>
            <button class="col-2 navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <img width="80%" src="https://image.flaticon.com/icons/png/512/55/55003.png" alt="">
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="ml-5 nav-item nav-link">
                        <b>
                            Conta Adiministrativa
                        </b>
                    </li>
                    <li class="btn btn-outline-light nav-item nav-link">
                        <a class="text-light" href="{{ route('sair') }}">Sair </a>
                    </li>
                </ul>
            </div>
    </nav>
    <!--conteudo-->
    <div class="d-flex justify-content-center"  >
        <div class="row container home">
            <!--funcionarios-->
            <div class="alert alert-primary" id="agenda" >
                
                <!--Escolher funcionario e ir para o scalendario-->
                <form action="{{ route('funcionario') }}"  method="get">
                    @csrf
                    
                    <div class="h3 col d-flex justify-content-center" >
                        <b>
                            Escolha o funcionario
                        </b>
                    </div>
                    
                    <input class="mb-2 col form-control" name="nome" type="text" placeholder="Nome do cliente" required>
                    <!-- Exibir nome dos funcionarios -->
                    @foreach ($funcionarios as $item)
                    
                        <label onclick="selecionar({{ $item->id }})" for="{{ $item->id }}" class="alert d-flex justify-content-center rosa s {{ $item->id }} ">
                            <input class="d-none" type="radio" name="funcionario" id="{{ $item->id }}" value="{{ $item->id }}" required >                               
                            <h2 class="col-10 }}" >
                                {{ $item->nome }}
                            </h2>
                            <a href="{{ route('removerFuncionario',['id'=> $item->id ]) }}" class="col-2" >
                                <img src="https://contmoura.com.br/wp-content/uploads/2019/09/x-png-icon-8.png" width="100%" alt="">
                            </a>
                        </label>
        
                    @endforeach
                    
                    <button class="form-control btn rosa mt-2" >Agendar>></button>
                </form>
                <!-- Adicionar funcionario -->  
                <form class="mt-3 alert alert-primary container m-0" action="{{ route('adicionarFuncionario') }}" method="POST">
                    @csrf
                    <hr >
                    <div class="h4 col d-flex justify-content-center" >
                        <b>Cadastrar funcionario</b>
                    </div>
                    <div class="mb-4 row m-0" >
                        <input class="col-8 form-control" name="nome"  type="text" placeholder="Digite o nome..." required>
                        <button class="col-md-3 col-4 ml-md-1 btn btn-outline-info" >Adicionar</button>
                    </div>
                </form>
                
            </div>
            <!--tratamentos-->
            <div class="alert alert-primary" id="horarios" >
                <!--Tratamento capilar-->
                <div class="container">

                    <div class="h3 col d-flex justify-content-center">
                        <b >Tratamentos capilar</b>
                    </div>

                    <!--Tratamentos capilar-->
                    @foreach ($tratamentos as $item)

                        <form class="row m-0 mt-1" style="height: 40px;"  action="{{ route('alterarTratamento',['id'=> $item->id]) }}" method="post">
                            @csrf
                            <input  class="ml-1 form-control col-4 col-md-6 " type="text" name="nome" value="{{ $item->nome }}">
                            <input class="ml-1 form-control col-2 " type="text"  name="valor" value="{{ $item->valor }}">
                            <a href="{{ route('removerTratamento',['id'=> $item->id]) }}" class="ml-1 col-2 col-md-1 btn btn-danger ">X</a>
                            <button class="ml-1 btn btn-success col " >Alterar</button>
                        </form>

                    @endforeach

                </div>
                <!--Adicionar tratamento capilar-->
                <div class="mt-4 container alert alert-primary" >
                    <hr>
                    <div class="h4 col d-flex justify-content-center" >
                        <b>Adicionar tratamento capilar</b>
                    </div>
                    <form class="row m-0 mb-2" action="{{ route('adicionarTratamento') }}" method="post">
                        @csrf
                        <input  class="ml-1 form-control col-4 " type="text" placeholder="nome"  name="nome" required>
                        <input class="ml-1 form-control col-3" type="text" placeholder="valor" name="valor" required>
                        <button class="ml-1 form-control btn-outline-info col-4" type="submit">Adicionar</button>
                    </form>
                </div>
            </div>
            <!--agenda-->
            <div class="col" >
                <!--Barra de pesquisa no momento desabilitada-->
                <form class="d-none row m-0 col mt-3" >
                    <input class="col-10 form-control" type="search" id="pesquisar" value="adm" placeholder="Pesquisar...">
                    <button id="send" type="submit" style="height: 40px;" class="col-2 rounded-right btn bg-info" >
                        <img style="transform: rotate(460deg)" class="row m-0 mb-4" width="90%" src="https://imagensemoldes.com.br/wp-content/uploads/2020/07/Ferramenta-Lupa-PNG.png" alt="">
                    </button>
                </form>

                <!--Cartoes exibindo os horarios marcados-->
                <div class="alert alert-primary h-100 " >

                    @foreach ($agendas as $item)
                    <!--cartao-->
                    
                    <div  class="card m-0 cart {{ $item->nome }} mt-1  ml-md-4" >
                        <!--data-->
                        <div class="card col-12 rosa" > 
                                {{ formatoData($item->data) }}
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
                                        <img width="100%" class="" src="https://logodownload.org/wp-content/uploads/2015/04/whatsapp-logo-1.png" alt="">
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