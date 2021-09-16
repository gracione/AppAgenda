<?php 
$tratamentos=session('tratamentos');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="660.4">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Calendario</title>
    <link rel="stylesheet" href="css/app.css" type="text/css">

</head>
<body>
    <nav class="text-white navbar navbar-expand-md navbar-primary alert rosa">
        <a class="col text-white w-50 nav-link navbar-brand" style="font-style: italic;" href="{{ route('inicial') }}">
            Estudio Hair alize
        </a>
        <b class="h2 col-5 col-md-2" >
            {{ session('nome') }}
        </b>
    </nav>
    
    <div class="col d-flex justify-content-center" >
        <form  action="{{ route('marcarHorario') }}" method="POST" class="calendario" >
            @csrf
            <!-- Calendario -->
            <div class="calendarioForm alert alert-primary" >
                <div class="w-100 text-black d-flex justify-content-center h2"  style="height: 10%;" >
                        <a href="{{ route('MesAnterior',['add'=> $funcionario]) }}">
                            <img style="transform: rotate(180deg);" width="20%;" src="https://4.bp.blogspot.com/-lwA6dGOaWEU/U1_8q21sQpI/AAAAAAAAMfM/69O45-_omnc/s200/www.png-free.blogspot.com+-+seta+luz+pink.png" alt="">

                        </a>
                        {{ $nomeMes }}        
                        <a href="{{ route('proximoMes',['add'=> $funcionario]) }}">
                            <img width="20%;" src="https://4.bp.blogspot.com/-lwA6dGOaWEU/U1_8q21sQpI/AAAAAAAAMfM/69O45-_omnc/s200/www.png-free.blogspot.com+-+seta+luz+pink.png" alt="">
                        </a>
                </div>
                <div style="height: 90%;witdh:100%;" >
                    @foreach ($diasDaSemana as $val => $item)
                    <div class="diaCalendario" >
                        <div class="diaSemana" >
                            {{ $val }}
                        </div>
                        @foreach ($item as $dia)
                        <input class="d-none" type="radio"  name="dia" id="{{ $dia }}">
                        <label onclick="selecionarDia({{ $dia}})" class="{{ $dia }} s border dia w-100 h-100" for="{{ $dia }}">
                            {{ $dia }}
                        </label>
                        @endforeach
                    </div>
                    @endforeach
                </div>  
            </div>
            <!-- Horario -->
            <div class="horarioForm alert alert-primary " >
                <div class="h3 col d-flex justify-content-center" >
                    <b>
                        Escolha um horario
                    </b>
                </div>
                    @foreach ($Horarios as $ke => $value)
                    
                        <div id="dia{{$ke}}" style="display: none;" class="dias">
                            @foreach ($relogio as $qualquer => $key )
                            <?php
                                $contador+=1;
                                $condicao=false;
                                ?>
                                @foreach ($value as $hora)
                                <div class="bg-dark" >
                                    <?php $hora->horario= (string) $hora->horario; ?>
                                </div>
                                @if ($hora->horario == $key)
                                        <?php $condicao=true; ?>
                                    @endif
                                @endforeach
                    
                                @if ($condicao)
                                    <label class="horario {{ $contador }} bg-secondary op" for="s{{ $contador }}">                        
                                        {{ $key }}
                                    </label>
                                @else
                                    <label onclick="selecionarHorario({{ $contador }})" class="horario {{ $contador }} op " for="s{{ $contador }}">            
                                        {{ $key }}
                                    </label>
                                    <input value="{{ $key."/".$ke }}" class="d-none" type="radio" name="horario" id="s{{ $contador }}" required>
                                @endif
                            @endforeach
                        </div>
                    
                    @endforeach    
            </div>
    
            <div class="container formulario alert alert-primary col " >
                <div class="d-none" >
                    <input type="text" name="mes" value="{{ $mes }}" >
                    <input type="text" name="ano" value="{{ $ano }}" >
                    <input type="text" name="funcionario" value="{{ $funcionario }}" >
                </div>
    
                <select name="tipo" class="mt-1 form-control" id="">
                    @foreach ($tratamentos as $item)
                        <option value="{{ $item->nome }}">{{ $item->nome }} ({{ $item->valor}} R$)</option>
                    @endforeach
                </select>
                <textarea class="mt-2 form-control" name="descricao" value="dd" id="" cols="140" rows="2">Descricao</textarea>
                <button class="mt-2 btn btn-info form-control" >Marcar</button>
            </div>
        </form>
    </div>    
</body>

<script>
    let selecionarDia = (id)=>{
        let elementos = document.getElementsByClassName('s');
        let elementos2 = document.getElementsByClassName('dias');

        for (let i = 0 ;i < elementos.length; i++) {
                elementos[i].style.background="white";
                elementos[i].style.color="black";
                document.getElementsByClassName(id)[0].style.background="#DA70D6";          
                document.getElementsByClassName(id)[0].style.color="white";          
        }
        for (let i = 0 ;i < elementos2.length; i++) {
                elementos2[i].style.display="none";
                document.getElementById('dia'+id).style.display="block";
        }
    }
    let selecionarHorario = (id)=>{
        let elementos = document.getElementsByClassName('horario');
        for (let i = 0 ;i < elementos.length; i++) {
                elementos[i].style.background="black";
                elementos[i].style.color="#DA70D6";
                document.getElementsByClassName('horario '+id)[0].style.background="#DA70D6";          
                document.getElementsByClassName('horario '+id)[0].style.color="white";          
        }
    }
</script>