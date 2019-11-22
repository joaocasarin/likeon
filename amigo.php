<?php
    session_start();
    if(!isset($_SESSION['id']))
    {
        header('Location: index.php');
        exit();
    }
    require_once('db.php');

    $db = new db();
    $link = $db->mysqlConnect();
    $amigo = $_POST['amigo'];
    $id = (int)$_SESSION['id'];
    $idAmigo = 0;

    $query2 = $link->prepare("SELECT id FROM usuario WHERE nome_usuario = ?");
    $query2->bind_param("s", $amigo);
    $run2 = $query2->execute();

    if($run2)
    {
        if($row = $query2->get_result()->fetch_array(MYSQLI_ASSOC))
            $idAmigo = (int)$row['id'];

        if($id != $idAmigo || $idAmigo==0)
        {
            $query3 = $link->prepare("INSERT INTO amigos (id, id_amigo) VALUES (?, ?);");
            $query3->bind_param("ii", $id, $idAmigo);
            $run3 = $query3->execute();

            if($run3)
            {
                $query4 = $link->prepare("INSERT INTO amigos (id, id_amigo) VALUES (?, ?);");
                $query4->bind_param("ii", $idAmigo, $id);
                $run4 = $query4->execute();

                if($run4)
                {               
                    echo         
                    '<script>
                        window.alert("Amigo adicionado!");
                    </script>
                    ';
                }
                else            
                    echo '<script>window.alert("Erro ao adicionar! "'.mysqli_error($link).');</script>';   
            }
            else        
                echo '<script>window.alert("Vocês já são amigos!");</script>';        
        }
        else    
            echo '<script>window.alert("Você não pode se adicionar!");</script>';
    }
    echo '<script>window.alert("Usuário inexistente! "'.mysqli_error($link).');</script>';   

    
    
    include 'amigos.php';
?>
