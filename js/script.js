function cadastro()
{
    window.open("cadastro.php", "_self");
}

function listar()
{
    window.open("listar.html", "_self");
}

function login()
{
    window.open("login.html", "_self");
}

function voltar()
{
    window.open("index.php", "_self");
}

function amigo()
{
    window.open("amigos.php", "_self");
}

function veramigos()
{
    window.open("veramigos.php", "_self");
}

function deletar(id_post){
    window.open('deletarpost.php?id='+id_post, '_self');
}

function logout(){
    window.open('logout.php', '_self');
}

function erroEmail(){
    document.getElementById('erroEmail').style.display = "block";     
}

function erroSenha(){
    document.getElementById('erroSenha').style.display = "block";  
}

function erroUsuario(){
    document.getElementById('erroUsuario').style.display = "block";  
}

function erroUsuarioNaoEncontrado(){
    document.getElementById('erroUsuarioNaoEncontrado').style.display = "block";  
}

function erroSenhaInvalida(){
    document.getElementById('erroSenhaInvalida').style.display = "block";  
}

function delUsuario(id){
    window.open('deletarusuario.php?id='+id, '_self');
}

function addUsuario(id){
    window.open('addamigo.php?id='+id, '_self');
}