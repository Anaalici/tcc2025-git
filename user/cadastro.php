<?php
include '../conexao.php';

$mensagem = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nome = trim($_POST['nomeUsuario'] ?? '');
    $dataNasc = trim($_POST['dataNasc'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contato = trim($_POST['contato'] ?? '');
    $senha = $_POST['senha'] ?? ''; 
    
    if (empty($nome) || empty($dataNasc) || empty($cpf) || empty($email) || empty($contato) || empty($senha)) {
        $mensagem = "ERRO: Por favor, preencha todos os campos obrigatórios.";
    } else {
        
        $sql_check = "SELECT cpf FROM usuario WHERE cpf = ?";
        
        $stmt_check = $conexao->prepare($sql_check);

        if ($stmt_check === false) {
            $mensagem = "Erro na preparação da consulta de verificação de CPF: " . $conexao->error;
        } else {
            
            $stmt_check->bind_param("s", $cpf);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                $mensagem = "ERRO: Já existe um usuário cadastrado com este CPF.";
            } else {
                
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                
                $sql_insert = "INSERT INTO usuario (nomeUsuario, dataNasc, cpf, email, contato, senha) 
                               VALUES (?, ?, ?, ?, ?, ?)";
                
                $stmt_insert = $conexao->prepare($sql_insert);
                
                if ($stmt_insert === false) {
                    $mensagem = "Erro na preparação da consulta de inserção: " . $conexao->error;
                } else {
                    
                    $stmt_insert->bind_param("ssssss", $nome, $dataNasc, $cpf, $email, $contato, $senha_hash);
                    
                    if ($stmt_insert->execute()) {
                        $mensagem = "USUÁRIO CADASTRADO COM SUCESSO! Redirecionando...";
                        
                        header("refresh:3; url=../index.html");
                        exit();
                        
                    } else {
                        $mensagem = "ERRO AO CADASTRAR: " . $stmt_insert->error;
                    }
                    
                    $stmt_insert->close();
                }
            }
            
            $stmt_check->close();
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
    <title>Cadastro - Receitas de Mestre</title>
        <link rel="icon" href="img/favicon.png" type="image/png">

</head>
<body>
    
<div class="tela">
    <section class="lado-esquerdo">
        <h1 class="h2-cad">Sign up</h1>

        <div class="social-icons">
            <img src="../user/userImg/facebook.png">
            <img src="../user/userImg/google.png">
            <img src="../user/userImg/linkedin.png">
        </div>

        <div class="inputs">
        <form class="formulario" method="POST" action="cadastro.php">

            <input type="text" name="fakeuser" autocomplete="username" style="display:none">
            <input type="password" name="fakepass" autocomplete="new-password" style="display:none">
        
            <input class="inputLogin" type="text" name="nomeUsuario" placeholder="Username" required autocomplete="off">

            <input class="inputLogin" type="date" name="dataNasc" required autocomplete="off">
            
            <input class="inputLogin" type="text" name="cpf" maxlength="14" placeholder="CPF" required autocomplete="off">

            <input class="inputLogin" type="email" name="email" placeholder="E-mail" required autocomplete="off">

            <input class="inputLogin" type="text" name="contato" placeholder="Telefone" maxlength="11" required autocomplete="off">

            <input class="inputLogin" type="password" id="senha" name="senha" placeholder="Senha" required autocomplete="off">


                    <div class="EsqueciS">
                        <input type="checkbox" id="mostrarSenha" onclick="togglePasswordVisibilityCheckbox()">
                        <label for="mostrarSenha" id="labelSenha">Mostrar Senha 👁️</label> 
                        
                        <input type="checkbox" id="termos">
                        <label for="termos" id="labelSenha">Li e aceito o <a href="termos.php">Termo de Uso</a></label>                     </div>

            <input class="btn" type="submit" name="cadastrar" value="Cadastrar">

            <p class="cadastro-conta">Já tem uma conta? <a href="../user/login.php" class="cadastro">Entrar</a></p>
        </form>
        </div>
    </section>

    <section class="lado-direito">
        <div class="fundo-laranja"></div>
        <img src="../user/userImg/cadastro.png" class="img-cadastro">
    </section>
</div>

</body>
</html>