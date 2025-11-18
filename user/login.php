<?php
session_start();

include '../conexao.php'; 


$mensagem = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? ''; 
    
    if (empty($email) || empty($senha)) {
        $mensagem = "ERRO: Por favor, preencha o email e a senha.";
    } else {
        
        $sql_login = "SELECT idUsuario, nomeUsuario, senha FROM usuario WHERE email = ?";
        
        $stmt_login = $conexao->prepare($sql_login);

        if ($stmt_login === false) {
            $mensagem = "Erro na preparação da consulta de login: " . $conexao->error;
        } else {
            
            $stmt_login->bind_param("s", $email);
            $stmt_login->execute();
            $result_login = $stmt_login->get_result();

            if ($result_login->num_rows === 1) {
                
                $usuario = $result_login->fetch_assoc();
                $senha_hash_bd = $usuario['senha']; 
                
                if (password_verify($senha, $senha_hash_bd)) {
                    
                    
                    $_SESSION['idUsuario'] = $usuario['idUsuario'];
                    $_SESSION['nomeUsuario'] = $usuario['nomeUsuario'];
                    
                    $mensagem = "LOGIN EFETUADO COM SUCESSO! Redirecionando...";
                    
                    header("refresh:3; url=../index.html"); 
                    exit();
                    
                } else {
                    $mensagem = "ERRO: Email ou senha incorretos.";
                }
                
            } else {
                $mensagem = "ERRO: Email ou senha incorretos.";
            }
            
            $stmt_login->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user/user.css">
    <script src="mostrarS.js" defer></script>
    <title>Login - Receitas de Mestre</title>
</head>
<body>

<div class="circle">
    <img class="imgSign" src="../user/userImg/user1.png" alt="">
    <div class="contanerBranco">
        <h2 class="h2">Sign in</h2>
            <div class="icons-container">
                <img class="icons" src="../user/userImg/facebook.png" alt="">
                <img class="icons" src="../user/userImg/google.png" alt="">
                <img class="icons" src="../user/userImg/linkedin.png" alt="">
            </div>

            <div class="inputs">
                <form method="POST" action="login.php" autocomplete="off"> 
                    
                    <input class="inputLogin" type="email" name="email" placeholder="Email" required autocomplete="off">
                    
                    <input class="inputLogin" type="password" id="senha" name="senha" placeholder="Senha" required autocomplete="off">

                    <div class="EsqueciS">
                        <input type="checkbox" id="mostrarSenha" onclick="togglePasswordVisibilityCheckbox()">
                        
                        <label for="mostrarSenha" id="labelSenha">Mostrar Senha 👁️</label> 
                        <a class="senha" href="#">Esqueci senha</a>
                    </div>
        
                    <input class="button" type="submit" value="Enviar">
                    <p class="cadastro-conta">Não tem uma conta? <a href="../user/cadastro.php" class="cadastro">Cadastrar-se</a></p> 
                </form>

            </div>
</div>

</body>
</html>