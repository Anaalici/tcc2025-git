<?php
include '../conexao.php';

$mensagem = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nomeUsuario'] ?? '');
    $dataNasc = trim($_POST['dataNasc'] ?? '');
    $cpf_formatado = trim($_POST['cpf'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contato_formatado = trim($_POST['contato'] ?? '');
    $senha = $_POST['senha'] ?? ''; 
    
    $cpf = preg_replace('/[^0-9]/', '', $cpf_formatado);
    $contato = preg_replace('/[^0-9]/', '', $contato_formatado);
    

    if (empty($nome) || empty($dataNasc) || empty($cpf) || empty($email) || empty($contato) || empty($senha) || strlen($senha) < 8 || strlen($cpf) !== 11 || strlen($contato) < 10 || strlen($contato) > 11) {
        $mensagem = "ERRO: Verifique se todos os campos foram preenchidos corretamente (Senha mín. 8 dígitos, CPF 11, Contato 10/11).";
    } else {
        $sql_check = "SELECT cpf FROM usuario WHERE cpf = ?";
        $stmt_check = $conexao->prepare($sql_check);
        $stmt_check->bind_param("s", $cpf);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $mensagem = "ERRO: Já existe um usuário cadastrado com este CPF.";
        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $sql_insert = "INSERT INTO usuario (nomeUsuario, dataNasc, cpf, email, contato, senha) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_insert = $conexao->prepare($sql_insert);
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
        $stmt_check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../user/user.css">
    <script src="mascaras.js" defer></script> 
    <title>Cadastro - Receitas de Mestre</title>
</head>
<body>
    
<div class="tela">
    <section class="lado-esquerdo">
        <h1 class="h2-cad">Sign up</h1>
        
        <?php if (!empty($mensagem)): ?>
            <p style="color: red; font-weight: bold; padding: 10px; border: 1px solid red; background-color: #ffe0e0;"><?= $mensagem ?></p>
        <?php endif; ?>

        <div class="social-icons">
            <img src="../user/userImg/facebook.png" alt="Facebook">
            <img src="../user/userImg/google.png" alt="Google">
            <img src="../user/userImg/linkedin.png" alt="LinkedIn">
        </div>

        <div class="inputs">
        <form class="formulario" id="cadastroForm" method="POST" action="cadastro.php"> 

            <input type="text" name="fakeuser" autocomplete="username" style="display:none">
            <input type="password" name="fakepass" autocomplete="new-password" style="display:none">
        
            <input class="inputLogin" type="text" name="nomeUsuario" placeholder="Username" required autocomplete="off">
            <input class="inputLogin" type="date" name="dataNasc" required autocomplete="off">
            <input class="inputLogin" type="text" id="cpf" name="cpf" maxlength="14" placeholder="CPF (000.000.000-00)" required autocomplete="off"> 
            <input class="inputLogin" type="email" name="email" placeholder="E-mail" required autocomplete="off">
            <input class="inputLogin" type="text" id="contato" name="contato" maxlength="15" placeholder="Telefone (DDD) 00000-0000" required autocomplete="off"> 

            <div class="input-group">
                <input class="inputLogin" type="password" id="senha" name="senha" placeholder="Senha (Mínimo 8 dígitos)" required autocomplete="new-password">
                <span toggle="#senha" class="fas fa-eye toggle-password" onclick="mostrarOcultarSenha(this)"></span>
            </div>
            
            <div class="termos-aceite">
                <input type="checkbox" id="termos" required>
                <label for="termos">Li e aceito o <a href="termos.php">Termo de Uso</a></label> 
            </div>

            <input class="btn" type="submit" name="cadastrar" value="Cadastrar">

            <p class="cadastro-conta">Já tem uma conta? <a href="../user/login.php" class="cadastro">Entrar</a></p>
        </form>
        </div>
    </section>

    <section class="lado-direito">
        <div class="fundo-laranja"></div>
        <img src="../user/userImg/cadastro.png" class="img-cadastro" alt="Imagem de Cadastro">
    </section>
</div>

</body>
</html>