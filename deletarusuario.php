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

    $id_amigo = (int)$_GET['id'];
    $id = (int)$_SESSION['id'];
    
    $query1 = $link->prepare("DELETE FROM amigos WHERE id_amigo = ? and id= ?;");
    $query1->bind_param("ii", $id_amigo,$id);
    $run1 = $query1->execute();

    $query2 = $link->prepare("DELETE FROM amigos WHERE id_amigo = ? and id= ?;");
    $query2->bind_param("ii", $id,$id_amigo);
    $run2 = $query2->execute();

    if($run1 && $run2)
    {
        header('Location: veramigos.php');
    }
    else
    {
        echo '<script>window.alert("Erro ao excluir! "'.mysqli_error($link).');</script>';  
        header('Location: paginapessoal.php');
    }
?>