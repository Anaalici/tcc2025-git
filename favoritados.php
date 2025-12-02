<?php
// Define que este arquivo deve ser PHP
header('Content-Type: text/html; charset=utf-8');

// Inclui o arquivo de conexão com o banco de dados.
// Certifique-se de que 'conexao.php' está no mesmo nível ou ajuste o caminho.
include 'conexao.php'; 

// Array que armazenará os detalhes das receitas criadas (do banco) favoritadas
$receitasCriadasFavoritas = [];

// Variável para armazenar a lista de IDs de receitas criadas que o JS precisa que o PHP busque.
// Esta lista será preenchida pelo JavaScript (via Query Parameter) na recarga da página.
$ids_favoritos_str = isset($_GET['ids_criadas']) ? $_GET['ids_criadas'] : '';

if (!empty($ids_favoritos_str) && isset($conexao) && !$conexao->connect_error) {
    
    // 1. Limpa e filtra os IDs, garantindo que sejam apenas números
    $ids_array = array_map('intval', explode(',', $ids_favoritos_str));
    $ids_array = array_filter($ids_array, function($id) { return $id > 0; });
    
    if (!empty($ids_array)) {
        // Converte o array de IDs em uma string separada por vírgulas para uso no SQL
        $ids_para_sql = implode(',', $ids_array);
        
        // 2. SQL para buscar as receitas criadas favoritadas
        $sql = "SELECT idReceita, nomeReceita, urlFoto, tempoMedio, dificuldade 
                FROM receita 
                WHERE idReceita IN ($ids_para_sql)";
        
        try {
            $resultado = $conexao->query($sql);
            
            if ($resultado && $resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    // Adiciona a receita formatada ao array
                    $receitasCriadasFavoritas[] = [
                        'id' => $row['idReceita'],
                        'nome' => $row['nomeReceita'],
                        'imagem' => $row['urlFoto'] ?? 'imgCategorias/default.jpg',
                        'tempo' => $row['tempoMedio'] ?? 'N/A',
                        'dificuldade' => $row['dificuldade'] ?? 'N/A',
                        'link' => 'receita.php?r=' . $row['idReceita'] // Link para a página PHP
                    ];
                }
            }
        } catch (Exception $e) {
            error_log("Erro ao buscar favoritos do banco: " . $e->getMessage());
        }
    }
}

// Converte as receitas do banco para JSON para que o JavaScript possa usar
$receitasCriadasJson = json_encode($receitasCriadasFavoritas);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Favoritos - Receita de Mestre</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/favicon.png" type="image/png">

    <style>
        /* CSS que você forneceu */
        body { font-family: Roboto, sans-serif; background: #f9f5f0; margin: 0; padding: 1.25em; color: #333; }
        .back-btn { display: inline-block; margin-bottom: 1em; padding: .5em .75em; background: #f39200; color: #fff; border-radius: .5em; text-decoration: none; }
        h1 { text-align: center; color: #f39200; margin: .5em 0 1.125em; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(13.75em, 1fr)); gap: 1.25em; }
        .card { background: #fff; border-radius: .75em; overflow: hidden; box-shadow: 0 .375em 1.25em rgba(0, 0, 0, .08); cursor: pointer; transition: transform .18s; position: relative; }
        .card:hover { transform: translateY(-.375em); }
        .card img { width: 100%; height: 8.75em; object-fit: cover; }
        .card-content { padding: .75em; }
        .card-content h3 { margin: 0; color: #f39200; font-size: 1.05rem; }
        .card-content p { margin: .375em 0 0; color: #555; font-size: .9rem; }
        .fav-btn { position: absolute; top: .625em; right: .625em; background-color: #fff; width: 2em; height: 2em; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 3; transition: transform .2s; }
        .fav-btn svg { width: 1.25em; height: 1.25em; fill: none; stroke: #000; stroke-width: .125em; }
        .fav-btn.active svg path { fill: #ff3b3b; stroke: #ff3b3b; }
        a { color: inherit; text-decoration: none; }
    </style>
</head>

<body>
    <section id="home">
        <header id="main-header">
            <div class="container">
                <div class="flex">
                    <a href="index.html"><img class="logo" src="./img/LogoTCC.png"></a>
                    <nav>
                        <ul class="menu">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="receitas.php">Receitas</a></li>
                            <li><a href="contato.php">Contato</a></li>
                            <li><a href="favoritados.php">Favoritad<span class="coracao"><i class="fas fa-heart"></i></span>s</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
    </section>

    <h1>Meus Favoritos</h1>
    <div class="grid" id="listaFavoritos"></div>

    <script src="receitasData.js"></script>
    <script>
        // Injeta a lista de receitas criadas favoritadas que foi buscada pelo PHP
        const receitasDoBanco = JSON.parse('<?= $receitasCriadasJson ?>');

        (function () {
            const favoritos = JSON.parse(localStorage.getItem("favoritos") || "[]");
            const container = document.getElementById("listaFavoritos");
            let listaFavoritos = [];

            // 1. Separa os IDs: Criadas (Numéricos) vs. Categorias (Strings/Outros)
            const idsReceitasCriadas = favoritos.filter(id => !isNaN(parseInt(id)) && id.toString() === parseInt(id).toString());
            const idsReceitasCategoria = favoritos.filter(id => isNaN(parseInt(id)) || id.toString() !== parseInt(id).toString());
            
            // 2. Verifica se precisamos recarregar a página para buscar as receitas criadas
            const urlParams = new URLSearchParams(window.location.search);
            const idsBuscadosNaURL = urlParams.get('ids_criadas');

            // Se a URL não tem os IDs, ou se a lista de IDs mudou, recarrega a página com os novos IDs
            if (idsReceitasCriadas.length > 0 && idsBuscadosNaURL !== idsReceitasCriadas.join(',')) {
                // Redireciona a página, enviando os IDs das receitas criadas para o PHP
                window.location.href = 'favoritados.php?ids_criadas=' + idsReceitasCriadas.join(',');
                return; // Interrompe a renderização para esperar o PHP retornar os dados
            }


            // 3. Combina as listas de Receitas
            // a) Adiciona as receitas de categoria (do receitasData.js)
            if (window.categorias) {
                let todasReceitasCategoria = [].concat(...Object.values(window.categorias));
                
                const favoritosCategoria = todasReceitasCategoria.filter(r => idsReceitasCategoria.includes(r.id));
                listaFavoritos = listaFavoritos.concat(favoritosCategoria);
            }

            // b) Adiciona as receitas criadas (do banco, injetadas pelo PHP)
            listaFavoritos = listaFavoritos.concat(receitasDoBanco);
            

            // 4. Renderização
            if (listaFavoritos.length === 0) {
                container.innerHTML = '<p style="grid-column:1/-1;padding:20px;background:#fff;border-radius:8px;">Você ainda não favoritou nenhuma receita.</p>';
                return;
            }

            listaFavoritos.forEach(r => {
                const card = document.createElement("div");
                card.className = "card";

                // O link deve apontar para o arquivo correto:
                // Se o link já veio do PHP (receita criada), usa r.link. Senão (receita de categoria), usa o antigo.
                const linkReceita = r.link || `receitas.html?r=${encodeURIComponent(r.id)}`;


                card.innerHTML = `
            <div class="fav-btn active" onclick="toggleFavorito(event,'${r.id}')">
              <svg viewBox="0 0 24 24">
                <path d="M12.1 8.64c-1.44-1.72-4.12-1.72-5.56 0a3.93 3.93 0 000 5.28L12 19.4l5.46-5.48a3.93 3.93 0 000-5.28c-1.44-1.72-4.12-1.72-5.36 0z"/>
              </svg>
            </div>
            <a href="${linkReceita}">
              <img src="${r.imagem}" alt="${r.nome}" onerror="this.onerror=null;this.src='imgCategorias/default.jpg';">
              <div class="card-content">
                <h3>${r.nome}</h3>
                <p>${r.dificuldade} • ${r.tempo}</p>
              </div>
            </a>
            `;
                container.appendChild(card);
            });
        })();

        window.toggleFavorito = function (e, id) {
            e.preventDefault();
            e.stopPropagation();

            const btn = e.currentTarget;
            btn.classList.toggle("active");

            let favs = JSON.parse(localStorage.getItem("favoritos") || "[]");
            if (btn.classList.contains("active")) {
                if (!favs.includes(id)) favs.push(id);
            } else {
                favs = favs.filter(x => x !== id);
            }

            localStorage.setItem("favoritos", JSON.stringify(favs));
            
            // Após desfavoritar, recarrega a página para remover o card da lista
            if (!btn.classList.contains("active")) {
                // A recarga simples garante que o card removido desapareça imediatamente
                window.location.reload(); 
            }
        }
    </script>
</body>

</html>