<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>LikeOn</title>
        <script src="js/jquery-3.4.1.js"></script>
        <script src="js/script.js"></script>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div class="container mt-sm-5" id="corpo">
            <form class="mx-5 pb-3" method="POST" action="cadastrar.php" target="_self">
                    <h2 class="display-4 pb-2" style="font-size: 40px; text-align: center;">Faça seu cadastro</h2>
                    <div class="row">
                        <div class="form-group col-sm-12 col-lg-6">
                                <label for="inputNome">Usuário</label>
                                <input type="text" class="form-control" name="usuario" aria-describedby="emailHelp" required autofocus>
                                <small class="form-text text-danger" id="erroUsuario" style="display: none;">Usuário indisponível!</small>
                        </div>
                        <div class="form-group col-sm-12 col-lg-6">
                                <label for="inputApelido">Telefone</label>
                                <input type="text" class="form-control" name="telefone" aria-describedby="emailHelp" >
                        </div>
                    </div>                   
                    <div class="row">
                        <div class="form-group col-sm-12 col-lg-6">
                            <label for="inputEmail">Endereço de e-mail</label>
                            <input type="email" class="form-control" name="email" aria-describedby="emailHelp" required>
                            <small class="form-text text-danger" id="erroEmail" style="display: none;">Os e-mails informados são diferentes!</small>
                        </div>
                        <div class="form-group col-sm-12 col-lg-6">
                            <label for="inputConfEmail">Confirme seu e-mail</label>
                            <input type="email" class="form-control" name="confEmail" aria-describedby="emailHelp" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-lg-6">
                            <label for="inputSenha">Senha</label>
                            <input type="password" class="form-control" name="senha" required>
                            <small class="form-text text-danger" id="erroSenha" style="display: none;">As senhas informadas são diferentes!</small>
                        </div>
                        <div class="form-group col-sm-12 col-lg-6">
                            <label for="inputConfSenha">Confirme sua senha</label>
                            <input type="password" class="form-control" name="confSenha" required >
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-lg-12">
                            <label for="inputSenha">Endereço</label>
                            <input type="text" class="form-control" name="endereco" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Enviar</button>
                    <button type="button" class="btn btn-primary" onclick="voltar()">Voltar</button>
                    
                </form>    
        </div>
    </body>
</html>
