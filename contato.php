<?php
require_once 'conexao.php'; 

$email_destino = "receitadmestre@gmail.com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome    = strip_tags(trim($_POST["nome"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $assunto = strip_tags(trim($_POST["assunto"]));
    $mensagem = trim($_POST["mensagem"]);
    
    $id_usuario = NULL; 

    if (empty($nome) OR empty($assunto) OR empty($mensagem) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contato.html?status=erro_campos");
        exit;
    }
    
    
    $stmt = $conn->prepare("INSERT INTO contato (nome, email, assunto, mensagem, idUsuario) VALUES (?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssssi", $nome, $email, $assunto, $mensagem, $id_usuario);
    $insercao_sucesso = $stmt->execute();
    $stmt->close();
    

    $cabecalhos = "De: {$nome} <{$email}> \r\n";
    $cabecalhos .= "Reply-To: {$email} \r\n";
    $cabecalhos .= "Content-Type: text/plain; charset=UTF-8";

    $corpo_email = "Você recebeu uma nova mensagem de contato do seu site (Também salva no DB).\n\n";
    $corpo_email .= "Nome: {$nome}\n";
    $corpo_email .= "Email: {$email}\n";
    $corpo_email .= "Assunto: {$assunto}\n\n";
    $corpo_email .= "Mensagem:\n{$mensagem}\n";

    $envio_sucesso = mail($email_destino, "CONTATO - {$assunto}", $corpo_email, $cabecalhos);

    if ($insercao_sucesso && $envio_sucesso) {
        header("Location: contato.html?status=sucesso");
    } else {
        header("Location: contato.html?status=erro_envio"); 
    }
    
    $conn->close();
    exit;

} else {
    header("Location: contato.html");
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
    <link rel="icon" href="/img/favicon.png" type="image/png">
</head>

<body>

        <section id="home">
        <header id="main-header">
            <div class="container">
                <div class="flex">
                    <a href="index.html"><img class="logo" src="./img/LogoTCC.png"></a>
                    <nav>
                        <ul class="menu">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="#receitas">Receitas</a></li>
                            <li><a href="contato.php">Contato</a></li>
                            <li><a href="#favoritos">Favoritad<span class="coracao"><i
                                            class="fas fa-heart"></i></span>s</a></li>

                            <!-- <div class="toggle-container">
                            <label class="switch">
                                <input type="checkbox" id="togglePaginas">
                                <span class="slidel-toggle">
                                    <span class="circle" id="circle">
                                        <span id="iconeSwitch">🍴</span>
                                    </span>
                                </span>
                            </label>
                        </div>   

                            <div class="search">
                                <label for="searchInput">
                                    <span <i class="fa-solid fa-magnifying-glass"></i></span>
                                </label>
                                <input type="text" id="searchInput" placeholder="Pesquisar">
                            </div>-->

                            <div class="userlogin">
                                <a href="login.php"><img class="loginuser" src="./img/user.png" alt=""></a>
                            </div>


                        </ul>
                    </nav>
                </div>
            </div>
        </header>
    </section>

    <section class="contato-container">
        <h2 class="titulo-contato">Fale diretamente com nossos chefs especialistas, sempre prontos para ajudar você a cozinhar com mais praticidade e sabor.</h2>
                <form class="form-contato" action="enviar_email.php" method="POST">
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


    <script src="script.js" defer></script>

</body>
</html>