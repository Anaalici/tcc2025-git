<?php
include 'conexao.php';

$mensagem = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user_input = trim($_POST['nome'] ?? '');
    $senha_digitada = $_POST['Senha'] ?? '';
    
    $sql = "SELECT idUsuario, nomeUsuario, senha FROM usuario WHERE nomeUsuario = ? OR email = ?";
    
    $stmt = $conexao->prepare($sql);
    
    if ($stmt === false) {
        $mensagem = "Erro na preparação da consulta: " . $conexao->error;
    } else {
        $stmt->bind_param("ss", $user_input, $user_input);
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();
            $senha_hash_armazenada = $usuario['senha'];
            
            if (password_verify($senha_digitada, $senha_hash_armazenada)) {
                
                $_SESSION['logado'] = TRUE;
                $_SESSION['idUsuario'] = $usuario['idUsuario'];
                $_SESSION['nomeUsuario'] = $usuario['nomeUsuario'];
                
                $mensagem = "Login efetuado com sucesso! Redirecionando...";
                
                header("refresh:2; url=index.html");
                exit();
                
            } else {
                $mensagem = "ERRO: Usuário ou senha incorretos.";
            }
        } else {
            $mensagem = "ERRO: Usuário ou senha incorretos.";
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user/user.css">
    <title>Login - Rceitas de Mestre</title>
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
                <form method="POST" action="login.php"> 
                    <input class="inputLogin" type="text" name="nome" placeholder="User" required>
                    
                    <input class="inputLogin" type="password" id="senha" name="Senha" placeholder="Senha" required>

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

<script>
    function togglePasswordVisibilityCheckbox() {
        // Busca os elementos pelo ID (é crucial que esses IDs estejam no seu HTML)
        const senhaInput = document.getElementById('senha');
        const checkbox = document.getElementById('mostrarSenha');
        const label = document.getElementById('labelSenha');

        if (checkbox.checked) {
            // Se marcado: MOSTRAR SENHA
            senhaInput.type = 'text'; 
            label.textContent = 'Esconder Senha'; 
        } else {
            // Se desmarcado: ESCONDER SENHA
            senhaInput.type = 'password'; 
            label.textContent = 'Mostrar Senha '; 
        }
    }
</script>

</body>
</html>