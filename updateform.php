<?php
    session_start();
    if(!isset($_SESSION['id']))
    {
        header('Location: index.php');
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
    <script src="js/jquery-3.4.1.js"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://kit.fontawesome.com/ea9bd1aadc.js" crossorigin="anonymous"></script>

    <script>
            $(document).ready(function()
            {                
                var session = "<?php echo $_SESSION['user']; ?>";
                
                $("#conf").click(function()
                {
                    window.open('updateform.php?user='+session, '_self');
                });
            });
        </script>
</head>
<body>  
    <div class="container " id="corpo">
        <h1 class='mb-4 text-center'><a href="paginapessoal.php"><img src='img/logo.png' alt='Logo' title="LikeOn"></a></h1>
        <hr class="mb-2">
        <div class="row"><h4 class="my-0 col-sm-6 col-6">Atualizar dados</h4>
            <div class="col-sm-6 text-right mt-1 col-6" style="font-size:20px; color: #007BFF">
                <a class="ml-3" style="cursor: pointer;" title="Adicionar amigo" onclick="amigo()"><i class="fas fa-user-plus"></i></a>
                <a class="ml-3" style="cursor: pointer;" title="Amigos" onclick="veramigos()"><i class="fas fa-user-friends"></i></a>
                <a class="ml-3" id="conf" style="cursor: pointer;" title="Configurações"><i class="fas fa-cog"></i></a>
                <a class="ml-3" id="logout" style="cursor: pointer;" title="Sair" onclick="logout()"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
        <hr class="mt-2">
    <?php
        require("db.php");

        $user = $_GET['user'];
        $db = new db();
        $link = $db->mysqlConnect();

        $query = $link->prepare("SELECT * FROM usuario INNER JOIN contato ON usuario.id = contato.id_usuario where usuario.nome_usuario = ?");
        $query->bind_param("s", $user);
        $run = $query->execute();
        $result = $query->get_result();
        
     
        if($run)
        {
            if($row = $result->fetch_array(MYSQLI_ASSOC))
            {
                echo 
                    "<form class='pb-3' method='POST' action='update.php' target='_self' enctype='multipart/form-data'>
                        <div class='row'>
                            <div class='form-group col-sm-12 col-lg-6'>
                                    <label for='inputNome'>Usuário atual</label>
                                    <input type='text' class='form-control' name='original' value='".$row['nome_usuario']."' readonly onfocus='this.blur()' style='background-color: lightgrey;'>
                            </div>
                            <div class='form-group col-sm-12 col-lg-6'>
                                    <label for='inputApelido'>Novo usuário</label>
                                    <input type='text' class='form-control' name='user' value='".$row['nome_usuario']."'>
                            </div>
                        </div>                   
                        <div class='row'>
                            <div class='form-group col-sm-12 col-lg-6'>
                                <label for='inputEmail'>Endereço de e-mail atual</label>
                                <input type='text' class='form-control' name='original2' value='".$row['email']."' readonly onfocus='this.blur()' style='background-color: lightgrey;'>
                            </div>
                            <div class='form-group col-sm-12 col-lg-6'>
                                <label for='inputConfEmail'>Novo endereço de e-mail</label>
                                <input type='text' class='form-control' name='email' value='".$row['email']."'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='form-group col-sm-12 col-lg-6'>
                                <label for='inputSenha'>Telefone atual</label>
                                <input type='text' class='form-control' name='original1' value='".$row['telefone']."' readonly onfocus='this.blur()' style='background-color: lightgrey;'>
                            </div>
                            <div class='form-group col-sm-12 col-lg-6'>
                                <label for='inputConfSenha'>Novo telefone</label>
                                <input type='text' class='form-control' name='telefone' value='".$row['telefone']."'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='form-group col-sm-12 col-lg-6'>
                                <label for='inputSenha'>Endereço atual</label>
                                <input type='text' class='form-control' name='original3' value='".$row['endereco']."' readonly onfocus='this.blur()' style='background-color: lightgrey;'>
                            </div>
                            <div class='form-group col-sm-12 col-lg-6 pb-2'>
                                <label for='inputConfSenha'>Novo endereço</label>
                                <input type='text' class='form-control' name='endereco' value='".$row['endereco']."'>
                            </div>
                        </div>
                        <div class = 'row'>
                            <div class='form-group col-sm-12 pb-2'>
                            <input type='file' class='btn btn-primary' name='fileToUpload' id='fileToUpload'>
                            </div>
                        </div>
                        
                        <button type='submit' class='btn btn-primary'>Atualizar</button>
                        <button type='button' class='btn btn-primary' onclick='voltar()'>Voltar</button>
                        
                    </form>    
            ";

            }
            else
            {
                echo "USUÁRIO NÃO ENCONTRADO. ".mysqli_error($link)."<br>";
                include 'voltar.html';
            }            
        }
        else
        {
            echo "QUERY NÃO EXECUTADA. ".mysqli_error($link)."<br>";
            include 'voltar.html';
        }     
        echo '</div>';
    ?>

</body>
</html>