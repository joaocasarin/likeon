<?php
    session_start();

    require('db.php');

    $username = $_POST['usuario'];
    $password = $_POST['senha'];

    $db = new db();
    $link = $db->mysqlConnect();

    $query = $link->prepare("SELECT id, nome_usuario, senhaHash, salt FROM usuario WHERE nome_usuario = ?;");
    $query->bind_param("s", $username);
    $run = $query->execute();
    $result = $query->get_result();

    if($run)
    {       
        if($row = $result->fetch_array(MYSQLI_ASSOC))
        {   
            if($row['senhaHash'] == md5(md5($password) . $row['salt']))
            {
               $_SESSION['id'] = $row['id'];
               $_SESSION['user'] = $row['nome_usuario'];
               
               session_write_close();

               header("Location: paginapessoal.php");
               exit();
            }
            else
            {                
                session_destroy();
                include 'index.php';
                echo '<script>erroSenhaInvalida();</script>';  
                
            }
        }
        else
        {            
            session_destroy();
            include 'index.php';
            echo '<script>erroUsuarioNaoEncontrado();</script>';  
        }
    }
    else
    {
        echo '<script>window.alert("Erro ao executar query! "'.mysqli_error($link).');</script>';  
        include 'index.php';
    }
?>