<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="20.4">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/app.css" type="text/css">

    <title>Login</title>

</head>
<body class="d-flex justify-content-center col" >
    <div id="paginaLogin" class="col-md-4 col-11">
        <div class="row m-0 mb-2 mt-5 " >
            <img class="w-100" src="https://blog.agenciadosite.com.br/wp-content/uploads/2017/02/logo-mancini-e1486727339396.jpg" alt="">
        </div>
        <form class="row m-0  alert alert-primary" action="{{ route('logar') }}" method="post">
            @csrf
            <label class="h3 container">Login</label>
            <input class="form-control" type="text" name="email" placeholder="Telefone" required >
            <input class="form-control" type="passwd" name="password" placeholder="Senha" required >
            <button class="btn col-12 rosa" name="login" type="submit" >Login</button>
            <a class="mt-2 col btn bg-primary text-white h4" href="{{ route('cadastro')}}">Cadastrar</a>
        </form>
    </div>
</body>
</html>