<?php
    session_start();
    if( isset($_SESSION['id'])){
        header("Location: paginapessoal.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LikeOn</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/jquery-3.4.1.js"></script>
    <script src="js/script.js"></script>
</head>

<body>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
              <h5 class="card-title text-center"><img src="img/logo.png" alt="Logo"></h5>
              <form class="form-signin" action="login.php" method="POST" target="_self">
                <div class="form-label-group">
                  <input type="text" id="inputEmail" name="usuario" class="form-control" placeholder="Usuário" required autofocus>
                  <label for="inputEmail">Usuário</label>
                  <small class="form-text text-danger" id="erroUsuarioNaoEncontrado" style="display: none;">Usuário não encontrado!</small>
                </div>
  
                <div class="form-label-group">
                  <input type="password" id="inputPassword" name="senha" class="form-control" placeholder="Senha" required>
                  <label for="inputPassword">Senha</label>
                  <small class="form-text text-danger" id="erroSenhaInvalida" style="display: none;">Senha inválida!</small>
                </div>              
       
                <input class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" value="Logar"/>
                <input class="btn btn-lg btn-google btn-block text-uppercase" type="button" value="Cadastrar" onclick="cadastro()">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>