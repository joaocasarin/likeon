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

    $id = 0;
    $user_original = $_POST['original'];
    $telefone_original = $_POST['original1'];
    $email_original = $_POST['original2'];
    $endereco_original = $_POST['original3'];

    $pastas_uploads = "img/";
    $arquivo_final = $pastas_uploads . basename($_FILES['fileToUpload']['name']);
    $uploadOk = 1;
    $tipoImagem = strtolower(pathinfo($arquivo_final, PATHINFO_EXTENSION));
    $arquivo_final = $pastas_uploads.$_SESSION['id'].'.'.$tipoImagem;

    if($tipoImagem != 'jpg' && $tipoImagem != 'png' && $tipoImagem != 'jpeg' && $tipoImagem != 'gif' )
    {
        echo "Nossa, mas nós só aceitamos JPG, JPEG, PNG, e GIF ;) <br>";
        $uploadOk = 0;
    }
    if($uploadOk == 0)
    {
        echo "Me desculpe, mas não podemos receber seu arquivo <br>";
    }
    else
    {
        if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $arquivo_final))
        {
            echo "O arquivo foi carregado com sucesso! <br>";
        }
        else
        {
            echo "Erro ao carregar o arquivo: <br>";
        }
    }

    $user = $_POST['user'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];

    $query = $link->prepare("SELECT id FROM usuario WHERE nome_usuario = ?");
    $query->bind_param("s", $user_original);
    $run = $query->execute();
    $result = $query->get_result();

    if($run)
    {
        if($row = $result->fetch_array(MYSQLI_ASSOC))
        {
            $id = (int)$row['id'];
            $query2 = $link->prepare("UPDATE usuario SET nome_usuario = ?, foto = ? WHERE id = ?");
            $query2->bind_param("ssi", $user, $arquivo_final, $id);
            $run2 = $query2->execute();

            if($run2)
            {
                $query3 = $link->prepare("UPDATE contato SET telefone = ?, email = ?, endereco = ? WHERE id_usuario = ?");
                $query3->bind_param("sssi", $telefone, $email, $endereco, $id);
                $run3 = $query3->execute();

                if($run3)
                {
                    header('Location: paginapessoal.php');
                }
                else
                {
                    echo '<script>window.alert("UPDATE CONTATO NÃO EXECUTADO! "'.mysqli_error($link).');</script>';  
                    header('Location: paginapessoal.php');
                }
            }
            else
            {
                echo '<script>window.alert("UPDATE USUARIO NÃO EXECUTADO! "'.mysqli_error($link).');</script>';  
                header('Location: paginapessoal.php');
            }
        }
        else
        {
            echo '<script>window.alert("USUARIO NÃO ENCONTRADO! "'.mysqli_error($link).');</script>';  
            header('Location: paginapessoal.php');
        }
    }
    else
    {
        echo '<script>window.alert("SELECT NÃO EXECUTADO! "'.mysqli_error($link).');</script>';  
        header('Location: paginapessoal.php');
    }
?>