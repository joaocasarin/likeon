<?php
    session_start();
    if(!isset($_SESSION['id']))
    {
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>LikeOn</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/jquery-3.4.1.js"></script>
        <script src="js/script.js"></script>
        <script src="https://kit.fontawesome.com/ea9bd1aadc.js" crossorigin="anonymous"></script>
        
        <script>
            $(document).ready(function()
            {                
                var session = "<?php echo $_SESSION['user']; ?>";
                
                $("#conf").click(function()
                {
                    window.open('updateform.php?user='+session, '_self');
                });
                function deletar(id_post)
                {
                    window.open('deletarpost.php?id='+id_post, '_self');
                }
            });
        </script>
    </head>
    <body>
        <div class="container" id="corpo">
        
            <h1 class='mb-4 text-center'><a href="paginapessoal.php"><img src='img/logo.png' alt='Logo' title="LikeOn"></a></h1>
            <hr class="mb-2">
            <div class="row"><h4 class="my-0 col-sm-6 col-6">Adicionar Amigos</h4>
                <div class="col-sm-6 text-right mt-1 col-6" style="font-size:20px; color: #007BFF">
                    <a class="ml-3" style="cursor: pointer;" title="Adicionar amigo" onclick="amigo()"><i class="fas fa-user-plus"></i></a>
                    <a class="ml-3" style="cursor: pointer;" title="Amigos" onclick="veramigos()"><i class="fas fa-user-friends"></i></a>
                    <a class="ml-3" id="conf" style="cursor: pointer;" title="Configurações"><i class="fas fa-cog"></i></a>
                    <a class="ml-3" id="logout" style="cursor: pointer;" title="Sair" onclick="logout()"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
            <hr class="mt-2">
       
            <form action="amigo.php" method="POST">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nome amigo" name="amigo" aria-describedby="button-addon2" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Adicionar</button>
                        </div>
                </div>
            </form>
            
            <?php
            
            require_once('db.php');

            $db = new db();
            $link = $db->mysqlConnect();
            $id = (int)$_SESSION['id'];

            $query = $link->prepare("SELECT * FROM usuario WHERE id not like ? and id not in (select id_amigo from amigos where id = ?) order by nome_usuario;");
            $query->bind_param("ii", $id,$id);
            $run = $query->execute();
            $result = $query->get_result();

            if($query)
            {   
                $cont = 0;
                $txt = "<div class='container px-0'><table class='table' style='border: 2px solid rgb(222,226,230); text-align: center;'>";
                while($row = $result->fetch_array(MYSQLI_ASSOC))
                {
                    if($cont%2 == 0){
                        $txt .= "<tr>";
                        $txt .= "<td style='border: 2px solid rgb(222,226,230);'><div class='row'><h5 class='my-0 mx-0 pr-0 col-9 col-md-10 text-left'>".$row['nome_usuario']."</h5><i class='fas fa-user-plus col-2 py-0 my-0 my-0 col-md-2 mr-0 mt-1 text-right' style='color:  #007BFF; cursor:pointer' onclick='addUsuario(".$row['id'].")'></i></div></td>";
                    }else if($cont%2 != 0){
                        $txt .= "<td style='border: 2px solid rgb(222,226,230);'><div class='row'><h5 class='my-0 mx-0 pr-0 col-9 col-md-10 text-left'>".$row['nome_usuario']."</h5><i class='fas fa-user-plus col-2 py-0 my-0 my-0 col-md-2 mr-0 mt-1 text-right' style='color:  #007BFF; cursor:pointer' onclick='addUsuario(".$row['id'].")'></i></div></td>";
                        $txt .= "</tr>";
                    }    
                                   
                    $cont++;
                }                       
            }
            $txt .= "</table></div>";
            echo $txt;

            ?>
            
        </div>
    </body>
</html>