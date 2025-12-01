<?php
session_start();
include '../conexao.php';

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $mensagem = "Preencha email e senha.";
    } else {

        $sql = "SELECT idUsuario, senha FROM usuario WHERE email = ?";
        $stmt = $conexao->prepare($sql);

        if (!$stmt) {
            $mensagem = "Erro de consulta: " . $conexao->error;
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows === 1) {

                $usuario = $resultado->fetch_assoc();
                $senha_hash_bd = $usuario['senha'];

                if (password_verify($senha, $senha_hash_bd)) {

                    $_SESSION['idUsuario'] = $usuario['idUsuario'];
                    
                    header("Location: ../index.html");
                    exit();

                } else {
                    $mensagem = "Email ou senha incorretos.";
                }

            } else {
                $mensagem = "Email ou senha incorretos.";
            }

            $stmt->close();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <script src="mascaras.js" defer></script> 
    
    <title>Login - Receitas de Mestre</title>
    <link rel="icon" href="img/favicon.png" type="image/png">

</head>
<body>

<div class="circle">
    <img class="imgSign" src="../user/userImg/user1.png" alt="">
    <div class="contanerBranco">
        <h2 class="h2">Sign in</h2>
        
        <?php if (!empty($mensagem)): ?>
            <p style="color: red; font-weight: bold; padding: 10px; border: 1px solid red; background-color: #ffe0e0;"><?= $mensagem ?></p>
        <?php endif; ?>
        
        <div class="icons-container">
            <img class="icons" src="../user/userImg/facebook.png" alt="Facebook">
            <img class="icons" src="../user/userImg/google.png" alt="Google">
            <img class="icons" src="../user/userImg/linkedin.png" alt="LinkedIn">
        </div>

        <div class="inputs">
            <form method="POST" action="./login.php" autocomplete="off">

                <input type="text" name="fakeuser" autocomplete="username" style="display:none">
                <input type="password" name="fakepass" autocomplete="new-password" style="display:none">
                    
                <div class="input-group">
                    <input class="inputLogin" type="email" name="email" placeholder="Email" required autocomplete="off">
                </div>
                
                <div class="input-group">
                    <input class="inputLogin" type="password" id="senha" name="senha" placeholder="Senha" required autocomplete="off">
                </div>
                <span toggle="#senha" class="fas fa-eye toggle-password" onclick="mostrarOcultarSenha(this)"></span>
                <div class="EsqueciS">
                    <a class="senha" href="../user/esqueceuS.php">Esqueci senha</a>
                </div>
        
                <input class="button" type="submit" value="Enviar">
                <p class="cadastro-conta">Não tem uma conta? <a href="../user/cadastro.php" class="cadastro">Cadastrar-se</a></p> 
            </form>

        </div>
    </div>
</div>

</body>
</html>