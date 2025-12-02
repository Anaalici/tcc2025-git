<?php
// Inclui o arquivo de conexão com o banco de dados
include 'conexao.php'; 

// --- LÓGICA DE BUSCA DAS RECEITAS NO BANCO ---

$receitasCadastradas = [];
$msgErro = '';

if (isset($conexao) && !$conexao->connect_error) {
    // SQL para selecionar as informações necessárias para a listagem
    $sql = "SELECT idReceita, nomeReceita, urlFoto, tempoMedio, dificuldade 
            FROM receita 
            ORDER BY idReceita DESC"; // Exibe as mais novas primeiro
    
    try {
        $resultado = $conexao->query($sql);
        
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $receitasCadastradas[] = [
                    'id' => $row['idReceita'],
                    'nome' => $row['nomeReceita'],
                    // Usa a URL salva no cadastro, com um fallback de imagem
                    'imagem' => $row['urlFoto'] ?? 'imgCategorias/default.jpg', 
                    'tempo' => $row['tempoMedio'] ?? 'N/A',
                    'dificuldade' => $row['dificuldade'] ?? 'N/A',
                ];
            }
        } else if ($resultado) {
            $msgErro = 'Nenhuma receita cadastrada ainda.';
        } else {
            $msgErro = 'Erro na consulta ao banco: ' . $conexao->error;
        }
        
    } catch (Exception $e) {
        $msgErro = "Erro na busca: " . $e->getMessage();
    }
} else {
    $msgErro = 'Erro de conexão com o banco de dados. Verifique o arquivo conexao.php.';
}

// Convertemos o array PHP para uma string JSON que o JavaScript irá usar para renderizar
$receitasJson = json_encode($receitasCadastradas);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Lista de Receitas</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="img/favicon.png" type="image/png">
    <style>
        /* CSS BÁSICO PARA OS CARDS (Mantido do seu estilo) */
        body { font-family: Roboto, sans-serif; background: #f9f5f0; margin: 0; padding: 1.25em; color: #333; }
        .back-btn { display: inline-block; margin-bottom: 1em; padding: 0.5em 0.75em; background: #f39200; color: #fff; border-radius: 0.5em; text-decoration: none; }
        h1 { text-align: center; color: #f39200; margin: 0.5em 0 1.125em; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(13.75em, 1fr)); gap: 1.25em; }
        .card { background: #fff; border-radius: 0.75em; overflow: hidden; box-shadow: 0 0.375em 1.25em rgba(0, 0, 0, 0.08); cursor: pointer; transition: transform .18s; position: relative; }
        .card:hover { transform: translateY(-0.375em); }
        .card img { width: 100%; height: 8.75em; object-fit: cover; }
        .card-content { padding: 0.75em; }
        .card-content h3 { margin: 0; color: #f39200; font-size: 1.05rem; }
        .card-content p { margin: 0.375em 0 0; color: #555; font-size: 0.9rem; }
        a { color: inherit; text-decoration: none; }
        .fav-btn { position: absolute; top: 0.625em; right: 0.625em; background-color: #fff; width: 2em; height: 2em; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 3; transition: transform .2s; }
        .fav-btn svg { width: 1.25em; height: 1.25em; fill: none; stroke: #000; stroke-width: 0.125em; }
        .fav-btn.active svg path { fill: #ff3b3b; stroke: #ff3b3b; }
        .area-add { display: none; }
        .error-message { grid-column: 1 / -1; padding: 1.25em; background: #fff; border-radius: 0.5em; border: 1px solid #f39200; text-align: center; }
        .add-btn-float { /* Botão de Adicionar flutuante ( + ) */
            position: fixed; 
            bottom: 2em; 
            right: 2em; 
            background: #f39200; 
            color: white; 
            border: none; 
            width: 3.5em; 
            height: 3.5em; 
            border-radius: 50%; 
            font-size: 2em; 
            line-height: 1; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            box-shadow: 0 0.25em 0.5em rgba(0, 0, 0, 0.3);
            cursor: pointer;
            z-index: 100;
        }
    </style>
</head>

<body>

    <a href="index.html" class="back-btn">← Voltar </a>
    <h1 id="tituloCategoria">Todas as Receitas</h1>
    
    <button class="add-btn-float" onclick="location.href='adicionarReceita.php'">+</button>

    <?php if (!empty($msgErro)): ?>
        <div class="grid">
            <p class="error-message"><?= htmlspecialchars($msgErro) ?></p>
        </div>
    <?php else: ?>
        <div class="grid" id="listaReceitas">
            </div>
    <?php endif; ?>

    <script>
        (function() {
            // Puxa o array de receitas que foi gerado pelo PHP e transformado em JSON
            const listaReceitas = JSON.parse('<?= $receitasJson ?>'); 
            const container = document.getElementById('listaReceitas');

            if (listaReceitas.length === 0) {
                return;
            }

            const favoritos = JSON.parse(localStorage.getItem("favoritos") || "[]");

            // 1. Gera os cards para exibição
            listaReceitas.forEach(r => {
                const card = document.createElement("div");
                card.className = "card";

                const ativo = favoritos.includes(r.id.toString()) ? "active" : ""; 

                card.innerHTML = `
                    <div class="fav-btn ${ativo}" onclick="toggleFavorito(event,'${r.id}')">
                        <svg viewBox="0 0 24 24">
                            <path d="M12.1 8.64c-1.44-1.72-4.12-1.72-5.56 0a3.93 3.93 0 000 5.28L12 19.4l5.46-5.48a3.93 3.93 0 000-5.28c-1.44-1.72-4.12-1.72-5.36 0z"/>
                        </svg>
                    </div>
                    <a href="receita.php?r=${r.id}">
                        <img src="${r.imagem}" alt="${r.nome}">
                        <div class="card-content">
                        <h3>${r.nome}</h3>
                        <p>${r.dificuldade} • ${r.tempo}</p>
                        </div>
                    </a>
                `;
                container.appendChild(card);
            });
            
            // 2. Função de Favoritar (Local Storage)
            window.toggleFavorito = function(e,id){
                e.preventDefault();
                e.stopPropagation();

                const btn = e.currentTarget;
                btn.classList.toggle("active");

                let favs = JSON.parse(localStorage.getItem("favoritos") || "[]");
                if(btn.classList.contains("active")){
                    if(!favs.includes(id)) favs.push(id);
                }else{
                    favs = favs.filter(x=>x!=id);
                }

                localStorage.setItem("favoritos",JSON.stringify(favs));
            }
        })();
    </script>
</body>
</html>