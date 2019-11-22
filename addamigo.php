<?php
    session_start();
    if(!isset($_SESSION['id']))
    {
        header('Location: index.php');
        exit();
    }
?>
<?php
    require_once('db.php');

    $db = new db();
    $link = $db->mysqlConnect();

    $idAmigo = (int)$_GET['id'];
    $id = (int)$_SESSION['id'];

    if($id != $idAmigo)
    {
            $query3 = $link->prepare("INSERT INTO amigos (id, id_amigo) VALUES (?, ?);");
            $query3->bind_param("ii", $id, $idAmigo);
            $run3 = $query3->execute();

            $query4 = $link->prepare("INSERT INTO amigos (id, id_amigo) VALUES (?, ?);");
            $query4->bind_param("ii", $idAmigo, $id);
            $run4 = $query4->execute();

            if($run3 && $run4)
            {                          
                
            }else            
                echo '<script>window.alert("Erro ao adicionar! "'.mysqli_error($link).');</script>';      
    }
    else    
        echo '<script>window.alert("Você não pode se adicionar!");</script>';  
    
    header('Location: amigos.php');
?>
