<?php
    session_start();
    if(!isset($_SESSION['id']))
    {
        header('Location: index.php');
        exit();
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <script src="js/jquery-3.4.1.js"></script>
        <script src="js/script.js"></script>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="https://kit.fontawesome.com/ea9bd1aadc.js" crossorigin="anonymous"></script>
        
        <title>LikeOn</title>

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
        <?php
            require("db.php");
            $db = new db();
            $link = $db->mysqlConnect();
            
            $querySelect = $link->prepare("SELECT * FROM usuario WHERE id = ?;");
            $querySelect->bind_param("i", $_SESSION['id']);
            $run = $querySelect->execute();
            $result = $querySelect->get_result();
            echo '<div class="container" id="corpo">';
            if($run)
            {
                if($row = $result->fetch_array(MYSQLI_ASSOC))
                {
                    $txt = "<h1 class='mb-4 text-center'><a href='paginapessoal.php'><img src='img/logo.png' alt='Logo' title='LikeOn'></a></h1>";
                    $txt .= '<hr class="mb-2">';
                    $txt .= '<div class="row"><h4 class="my-0 col-sm-6 col-6">'.$row['nome_usuario'].'</h4>';
                    $txt .= '<div class="col-sm-6 col-6 text-right mt-1" style="font-size:20px; color: #007BFF">';
                    $txt .= '<a class="ml-3" style="cursor: pointer;" title="Adicionar amigo" onclick="amigo()"><i class="fas fa-user-plus"></i></a>';
                    $txt .= '<a class="ml-3" style="cursor: pointer;" title="Amigos" onclick="veramigos()"><i class="fas fa-user-friends"></i></a>';
                    $txt .= '<a class="ml-3" id="conf" style="cursor: pointer;" title="Configurações"><i class="fas fa-cog"></i></a>';
                    $txt .= '<a class="ml-3" id="logout" style="cursor: pointer;" title="Sair" onclick="logout()"><i class="fas fa-sign-out-alt"></i></a></div></div>';
                    $txt .= '<hr class="mt-2">';
                    echo $txt;
                }
                else
                {
                    echo "USUÁRIO NÃO ENCONTRADO.<br>";
                    include 'voltar.html';
                }
            }
            else
            {
                echo "QUERY NÃO EXECUTADA. ".mysqli_error($link)."<br>";
                include 'voltar.html';
            }           
        ?>
        <form class="mt-3 pb-0" method="POST" action="postar.php" target="_self">
                           
            <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Conteúdo" name="conteudo" aria-describedby="button-addon2" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Postar</button>
                </div>
            </div>
        </form>
        <?php   
            
            $db = new db();
            $link = $db->mysqlConnect();

            $id = (int)$_SESSION['id'];            
            $query = $link->prepare("SELECT *, DATE_FORMAT(data,'%d/%m/%Y %H:%i') AS data_formatada FROM posts 
                                        INNER JOIN usuario where (usuario.id = posts.id_usuario and usuario.id = ?) or (usuario.id = ? and posts.id_usuario in 
                                        (SELECT id_amigo FROM amigos WHERE id = ?)) order by data desc limit 20");
            $query->bind_param("iii",$id,$id,$id);
            $run = $query->execute();
            $result = $query->get_result();
            
            
            if($run)
            {
                $txt = '<div id="post" class="mb-3">';
                while($row = $result->fetch_array(MYSQLI_ASSOC))
                {
                    $query1 = $link->prepare("SELECT nome_usuario, foto FROM usuario WHERE id=?;");
                    $query1->bind_param("i",$row["id_usuario"]);
                    $run1 = $query1->execute();
                    $result1 = $query1->get_result();                    

                    $txt .= '<table class="table" style="border: 2px solid rgb(222,226,230);">';                    

                    if($id == $row['id_usuario']){
                        if($row['foto']==NULL)
                            $foto = "<img src='img/user.png' alt='Logo' width='40px' height='40px'>";
                        else
                            $foto = "<img src='".$row['foto']."' alt='Logo' width='40px' height='40px'>";
                        
                        $txt .= "<thead class='thead-light'><tr class='py-0'><th class='p-1 pl-3'><div class='row'><div class='ml-2'>".$foto."</div><p class='col-sm-5 col-5 mb-0 pl-2 my-2'>".$row['nome_usuario']."</p><p class='col-sm-5 col-5 mb-0 text-right my-2 pr-0' style='text-align = right; font-size: 14px;'>".$row['data_formatada']."</p></div></th></tr></thead>";
                        $txt .= "<tbody><tr><td><p>".$row['conteudo']."</p><br>";

                        $txt .= "<hr class='mb-2'><div class='text-right'><button type='button' class='btn btn-primary' onclick='deletar(".$row['id_post'].")'>Excluir</button></div></td></tr></tbody>";
                    }else if($row2 = $result1->fetch_array(MYSQLI_ASSOC)){   
                        if($row2['foto']==NULL)
                            $foto = "<img src='img/user.png' alt='Logo' width='40px' height='40px'>";
                        else
                            $foto = "<img src='".$row2['foto']."' alt='Logo' width='40px' height='40px'>";   

                        $txt .= "<thead class='thead-light'><tr class='py-0'><th class='p-1 pl-3'><div class='row'><div class='ml-2'>".$foto."</div><p class='col-sm-5 col-5 mb-0 pl-2 my-2'>".$row2['nome_usuario']."</p><p class='col-sm-5 col-5 mb-0 text-right my-2 pr-0' style='text-align = right; font-size: 14px;'>".$row['data_formatada']."</p></div></th></tr></thead>";
                        $txt .= "<tbody><tr><td><p>".$row['conteudo']."</p><br>";                            
                    } 
                           
                    $txt .= '</table>';    
                }
                $txt.='</div>';
      
                echo $txt;
                
            }
            else{
                echo '<h1>Erro ao executar query!</h1>'.mysqli_error($link).'<br>';

            }
        ?>

        </div>
    </body>
</html>