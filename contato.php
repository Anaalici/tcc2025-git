<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'conexao.php';

$email_destino = "receitadmestre@gmail.com";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome       = strip_tags(trim($_POST["nome"]));
    $email      = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $assunto    = strip_tags(trim($_POST["assunto"]));
    $mensagem   = trim($_POST["mensagem"]);
    $id_usuario = NULL; 

    if (empty($nome) OR empty($assunto) OR empty($mensagem) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contato.php?status=erro_campos");
        exit;
    }
    
    $insercao_sucesso = false;
    try {
        $stmt = $conexao->prepare("INSERT INTO contato (nome, email, assunto, mensagem, idUsuario) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $nome, $email, $assunto, $mensagem, $id_usuario);
        $insercao_sucesso = $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        $insercao_sucesso = false;
    }
    
    
    $envio_sucesso = false;
    $email_autenticacao = 'gabrihel.camargo1234@gmail.com'; 
    $senha_app          = 'bwonsplblguffszz';   

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP(); 
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = $email_autenticacao;
        $mail->Password   = $senha_app;    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587; 
        $mail->CharSet    = 'UTF-8'; 

        $mail->setFrom($email_autenticacao, 'Contato do Seu Site'); 
        
        $mail->addReplyTo($email, $nome); 

        $mail->addAddress($email_destino);
        
        $mail->isHTML(false); 
        $mail->Subject = "CONTATO - {$assunto}";
        
        $corpo_email = "Você recebeu uma nova mensagem de contato do seu site.\n\n";
        $corpo_email .= "Nome: {$nome}\n";
        $corpo_email .= "Email: {$email}\n";
        $corpo_email .= "Assunto: {$assunto}\n\n";
        $corpo_email .= "Mensagem:\n{$mensagem}\n";

        $mail->Body = $corpo_email;

        $mail->send();
        $envio_sucesso = true;

    } catch (Exception $e) {
        $envio_sucesso = false;
    }
    
    if ($insercao_sucesso && $envio_sucesso) {
        header("Location: contato.php?status=sucesso"); 
    } else {
        header("Location: contato.php?status=erro_envio"); 
    }
    
    $conexao->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="icon" href="img/favicon.png" type="image/png">
</head>

<body>

          <header id="main-header">
            <div class="container">
                <div class="flex">
                    <a href="index.html"><img class="logo" src="./img/LogoTCC.png"></a>
                    <nav>
                        <ul class="menu">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="receitas.php">Receitas</a></li>
                            <li><a href="contato.php">Contato</a></li>
                            <li><a href="favoritados.php">Favoritad<span class="coracao"><i
                                            class="fas fa-heart"></i></span>s</a></li>

                                            <li class="toggle-control-item">
           <div class="icon-toggle" id="page-toggle">
    <span class="toggle-state" data-view="recipes"> <i class="fa-solid fa-pepper-hot"></i> 
    </span>
    <span class="toggle-state" data-view="utensils">
        <i class="fa-solid fa-utensils"></i>
    </span>
</div>
        </li>

                            <div class="userlogin" id="btnLogin">
    <a href="./user/login.php">
        <i class="fa-solid fa-right-to-bracket loginuser-icon"></i>
    </a>
</div>

<div class="userperfil" id="btnPerfil" style="display: none;">
    <a href="contaUsuario.html">
        <img class="loginuser" src="./img/entrar.png" alt="">
    </a>
</div>

                        </ul>
                    </nav>
                </div>
            </div>
        </header>

    <section class="contato-container">
        <h2 class="titulo-contato">Fale diretamente com nossos chefs especialistas, sempre prontos para ajudar você a cozinhar com mais praticidade e sabor.</h2>
                <form class="form-contato" action="contato.php" method="POST">
            <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>

            <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>

            <label for="assunto">Assunto</label>
                        <select id="assunto" name="assunto" required>
                                <option value="" disabled selected>---</option>
                <option value="Duvida">Dúvida</option>
                <option value="Comercial">Falar com departamento comercial</option>
                <option value="Erro">Comentar sobre erro encontrado</option>
                <option value="Sugestao">Fazer uma sugestão, crítica ou elogio</option>
                <option value="Outro">Outros</option>
            </select>

            <label for="mensagem">Sua mensagem</label>
                        <textarea class="" id="mensagem" name="mensagem" rows="6" placeholder="Digite aqui o assunto" required></textarea>

            <button type="submit" class="btn-enviar">Enviar</button>
        </form>
    </section>

    <script>
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        const status = getQueryParam('status');

        if (status === 'sucesso') {
            alert('✅ Mensagem enviada com sucesso! Logo entraremos em contato.');
            window.history.replaceState(null, null, window.location.pathname);
        } else if (status === 'erro_envio') {
            alert('❌ Ops! Não foi possível enviar sua mensagem. Verifique a conexão ou tente novamente mais tarde.');
            window.history.replaceState(null, null, window.location.pathname);
        } else if (status === 'erro_campos') {
            alert('⚠️ Por favor, preencha todos os campos obrigatórios corretamente.');
            window.history.replaceState(null, null, window.location.pathname);
        }
    </script>

    <script src="script.js" defer></script>

</body>
</html>