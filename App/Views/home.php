<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Agenda</title>
</head>
<body>
<div class="container">   

            <?php 
                if(isset($error)){
                echo'<span>.'.$error .'.</span>';
                }
             ?>


    <div class="card bg-dark text-white" style="
            width: 600px;
            height: 198px;
            margin-top: 70px;
            margin-left: 288px;" id="div-login">
      <form action="<?= APP_URL.'login/logar'?>" method="POST">
            <div class="form-group" >
                <label for="exampleInputEmail1">Endereço de email</label>
                <input type="email" name="email" class="form-control" id="loginInputEmail" aria-describedby="emailHelp" placeholder="Seu email">
                <!-- <small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small> -->
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Senha</label>
                <input type="password" name="senha" class="form-control" id="loginInputPassword" placeholder="Senha">
            </div>
            <div class="form-group"></div>

            <div class="form-group" style="margin-top: 7px;">
                <button id="btnLogin" type="submit" class="btn btn-primary">Logar</button>
            </div>
      </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>