<?php
session_start();
require'conexao.php';
$email = $_POST['email'];
$senha = md5($_POST['senha']);
$sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
$result = $conn->query($sql);
if($result->num_rows>0){
    $user = $result->fetch_assoc();
    $_SESSION['logado'] = true;
    $_SESSION['nome'] = $user['nome'];
    $_SESSION['nivel'] = $user['nivel'];
    if($user['nivel'] == 'admin'){
        header ("Location: painel_admin.php");
    }else{
         header ("Location: painel_usuario.php");
    }
    exit;
}else{
    $_SESSION['erro'] = "Usuário ou senha inválidos!";
     header ("Location: index.php");
     
}
?>