<?php
// *******************************************************************
// 1. LÓGICA DE SESSÃO E CONEXÃO
// *******************************************************************

// Inclui o arquivo que inicia a sessão e cria a variável $conexao
require_once 'conexao.php'; 

// Variáveis de controle
$usuario_logado = false;
// Imagem padrão (Ícone de login)
$foto_perfil_caminho = "./img/entrar.png"; 

// 2. Verifica se o usuário está logado (se o ID está na sessão)
if (isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $usuario_logado = true;

    // 3. Busca o caminho da foto de perfil no banco de dados usando $conexao
    // Consulta preparada para maior segurança (contra SQL Injection)
    $sql = "SELECT foto_perfil FROM usuarios WHERE id = ?";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        // O caminho da foto real do usuário é definido aqui, com sanitização
        $foto_perfil_caminho = htmlspecialchars($usuario['foto_perfil']); 
    }
    
    $stmt->close();
}

// 4. (Opcional) Fecha a conexão após o uso
// $conexao->close();

// *******************************************************************
?>
<!DOCTYPE html>
<html lang="pt-bt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receitas de Mestre</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="icon" href="./img/favicon.png" type="image/png">
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
                            <li><a href="receitas.php">Receitas</a></li>
                            <li><a href="contato.php">Contato</a></li>
                            <li><a href="favoritados.php">Favoritad<span class="coracao"><i
                                                class="fas fa-heart"></i></span>s</a></li>

                            <li class="toggle-control-item">
                                <div class="icon-toggle" id="page-toggle">
                                    <span class="toggle-state" data-view="recipes">
                                        <i class="fa-solid fa-pepper-hot"></i>
                                    </span>

                                    <span class="toggle-state" data-view="utensils">
                                        <i class="fa-solid fa-utensils"></i>
                                    </span>
                                </div>
                            </li>

                            <?php
                            // *******************************************************************
                            // Bloco modificado: Exibe o perfil ou o botão de login
                            // *******************************************************************
                            if ($usuario_logado) {
                                // Se o usuário estiver logado, exibe a imagem de perfil
                                echo '
                                <div class="userperfil" id="btnPerfil">
                                    <a href="contaUsuario.html">
                                        <img class="loginuser" src="' . $foto_perfil_caminho . '" alt="Foto de Perfil">
                                    </a>
                                </div>';
                            } else {
                                // Se o usuário NÃO estiver logado, exibe o ícone de login
                                echo '
                                <div class="userlogin" id="btnLogin">
                                    <a href="./user/login.php">
                                        <i class="fa-solid fa-right-to-bracket loginuser-icon"></i>
                                    </a>
                                </div>';
                            }
                            // *******************************************************************
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
    </section>

    <section id="home">
        <div class="slider">
            <div class="slides">
                <img class="slide" src="./img/banner.png" alt="foto1">
                <img class="slide" src="./img/cupcakeC.png" alt="foto2">
                <img class="slide" src="./img/pizza.png" alt="foto3">
                <img class="slide" src="./img/frango.png" alt="foto4">
                <img class="slide" src="./img/banner.png" alt="foto1">
            </div>
        </div>
    </section>

    <section id="tematico">
        <h2 class="hallo">Receitas para o Natal</h2>
        <div class="cards-container">
            <a href="biscoito.html" class="card">
                <img src="imgCategorias/frangi.avif" alt="biscoito">
                <p>Frango Assado</p>
            </a>

            <a href="almoco-rapido.html" class="card">
                <img src="img/biscoitoN.jpg" alt="Receitas para almoço rápido">
                <p>Biscoito de Gengibre</p>
            </a>

            <a href="chocotone.html" class="card">
                <img src="imgCategorias/choco.jpg" alt="Receitas de sobremesas fáceis">
                <p>Chocotone</p>
            </a>

            <a href="fit.html" class="card">
                <img src="imgCategorias/salpicao.jpg" alt="Receitas fit e saudáveis">
                <p>Salpicão</p>
            </a>

            <a href="almoco-domingo.html" class="card">
                <img src="imgCategorias/manjar.jpg" alt="Receitas para almoço de domingo">
                <p>Manjar de Coco</p>
            </a>

            <a href="almoco-domingo.html" class="card">
                <img src="imgCategorias/fricasse.png" alt="Receitas para almoço de domingo">
                <p>Fricassê</p>
            </a>
        </div>

    </section>


    <section id="pesquisa">
        <div class="pesquisameio">
            <h2 class="h2search">O que você quer preparar hoje?</h2>
            <div class="pesquisa">
                <input type="text" id="meuInput" placeholder="Pesquisar receita">
            </div>
            <a href="#" class="botaoEnviar">Pesquisar</a>
        </div>
    </section>

    <center>
        <section id="categoria">
            <div class="receitas">
                <a href="receitasC.html?cat=japonesa" class="card1">
                    <img src="imgCategorias/japonesa.webp" alt="japones">
                </a>
                <a href="receitasC.html?cat=vegana" class="card1">
                    <img src="imgCategorias/vegano.png" alt="alface">
                </a>
                <a href="receitasC.html?cat=massadoce" class="card1">
                    <img src="imgCategorias/massaDoce.png" alt="panqueca">
                </a>
                <a href="receitasC.html?cat=lanches" class="card1">
                    <img src="imgCategorias/lanches.png" alt="lanche natural">
                </a>
            </div>
        </section>

        <section id="carrossel">
            <h2 class="vistasR">Queridinhas da semana</h2>

            <div class="carrossel-track">
                <div class="car-item">
                    <img src="img/bolocenoura.jpg" alt="bolodecenoura">
                    <div class="info-slide">
                        <h2 class="titulo">Bolo de cenoura fofinho e <br> fácil</h2>
                        <p class="subtitulo">"Melhor bolo que já comi!! Massa fofinha e nada enjoativa."</p>
                        <a class="btn-receitas" href="receitasMP.html?r=bolocenoura">Ver receita</a>
                    </div>
                </div>

                <div class="car-item">
                    <img src="img/frango9.jpg" alt="frango empanado">
                    <div class="info-slide">
                        <h2 class="titulo">Frango empanado crocante</h2>
                        <p class="subtitulo">"Uma delícia! Ficou sequinho e nem sujou tanto."</p>
                        <a href="receitasC.html?id=frangoEmpanado" class="btn-receitas">Ver receita</a>
                    </div>
                </div>

                <div class="car-item">
                    <img src="img/oi.avif" alt="Strogonoff">
                    <div class="info-slide">
                        <h2 class="titulo">Strogonoff de frango</h2>
                        <p class="subtitulo">"Maravilhoso, fiz ontem pela primeira vez e amei!."</p>
                        <a href="receitasC.html" class="btn-receitas">Ver receitas</a>
                    </div>
                </div>
            </div>

        </section>

    <footer class="site-footer">
        <div class="footer-content">
            
            <div class="footer-section footer-links">
                <h3>Navegação</h3>
                <ul>
                    <li><a href="termos.php">Termos de Uso</a></li>
                    <li><a href="contato.php">Entre em Contato</a></li>
                    <li><a href="duvidas.html">Dúvidas Frequentes (FAQ)</a></li>
                </ul>
            </div>
            
            <div class="footer-section footer-recursos">
                <h3>Recursos</h3>
                <ul>
                    <li><a href="guias_iniciantes.html">Guia para Iniciantes</a></li>
                    <li><a href="receitas_populares.php">Receitas Populares</a></li>
                    <li><a href="parceiros.php">Parceiros e Afiliados</a></li>
                </ul>
            </div>

            <div class="footer-section footer-contact">
                <h3>Fale Conosco</h3>
                <p>
                    <i class="fas fa-phone-alt"></i> 
                    (31) 99876-5432 (Fictício)
                </p>
                <p>
                    <i class="fas fa-envelope"></i> 
                    <a href="mailto:receitadmestre@gmail.com">receitadmestre@gmail.com</a>
                </p>
                <div class="divider"></div> 
            </div>
            
        </div>

        <div class="footer-bottom">
            &copy; 2025 Receita de Mestre | Todos os direitos reservados.
        </div>
    </footer>


        <script src="receitas.js" defer></script>
        <script src="script.js" defer></script>

</body>
</html>