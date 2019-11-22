<?php
    session_start();
    if(!isset($_SESSION['id']))
    {
        header('Location: index.php');
        exit();
    }
?>

<?php
    require('db.php');

    $db = new db();
    $link = $db->mysqlConnect();

    $id_post = (int)$_GET['id'];
    $id = (int)$_SESSION['id'];

    $query = $link->prepare("DELETE FROM posts WHERE id_post = ?");
    $query->bind_param("i", $id_post);
    $run = $query->execute();

    if($run)
    {
        header('Location: paginapessoal.php');
    }
    else
    {
        echo '<script>window.alert("Erro ao excluir! "'.mysqli_error($link).');</script>';  
        header('Location: paginapessoal.php');
    }
?>