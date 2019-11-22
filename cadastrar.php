<?php
    require('db.php');

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $confEmail = $_POST['confEmail'];
    $confSenha = $_POST['confSenha'];
    $endereco = $_POST['endereco'];

    $db = new db();

    $confirmacao = true;
    $salt = rand(1, 10000);
    $saltHash = md5((string)$salt);
    $senhaHash = md5($senha);
    $fimHash = md5($senhaHash.$saltHash);

    include 'cadastro.php';

    if($email != $confEmail){      
        echo "<script>erroEmail();</script>";
        $confirmacao = false;
    }
    if($senha != $confSenha){
        echo "<script>erroSenha();</script>";
        $confirmacao = false;
    }

    if($confirmacao){
        $link = $db->mysqlConnect();

        $queryUsuario = $link->prepare("INSERT INTO usuario (nome_usuario, salt, senhaHash) VALUES (?, ?, ?);");
        $queryUsuario->bind_param("sss", $usuario, $saltHash, $fimHash);
        $run = $queryUsuario->execute();

        if($run)
        {
            $queryContato = $link->prepare("INSERT INTO contato (id_usuario, telefone, email, endereco) VALUES ((SELECT id FROM usuario WHERE nome_usuario = ?), ?, ?, ?);");
            $queryContato->bind_param("ssss", $usuario, $telefone, $email, $endereco);
            $run2 = $queryContato->execute();
            
            if($run2)            
                header ('Location: index.php');
        }
        else
        {
            echo "<script>erroUsuario();</script>";
        }
    }
?>