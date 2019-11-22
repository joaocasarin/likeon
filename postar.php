<?php
    session_start();
    if(!isset($_SESSION['id']))
    {
        header('Location: login.php');
        exit();
    }
?>

<?php
    require('db.php');
    date_default_timezone_set('UTC');

    $id = (int)$_SESSION['id'];
    $conteudo = $_POST['conteudo'];
    $date = date("Y-m-d H:i:s");

    if(!isset($conteudo))
    {
        header('Location: paginapessoal.php');
        exit();
    }
    $db = new db();
    $link = $db->mysqlConnect();

    $query = $link->prepare("INSERT INTO posts (id_usuario, conteudo, data) VALUES (?, ?, ?);");
    $query->bind_param("iss", $id, $conteudo, $date);
    $run = $query->execute();

    if($run)
    {
        echo '<h1>POSTADO COM SUCESSO</h1><br>';
        header("Location: paginapessoal.php");
        
    }
    else
    {
        echo '<h1>Erro ao executar query!</h1>'.mysqli_error($link)."<br>";
        include 'pp.html';
    }
?>