<?php
// --- LÓGICA DE BUSCA DA RECEITA NO BANCO DE DADOS ---
// O arquivo de conexão deve estar neste diretório e inicializar a variável $conexao
include 'conexao.php'; 

$receita = null;
$msgErro = '';
$ingredientes_array = [];
$preparo_array = [];
$utensilios_texto = 'Nenhum utensílio listado.'; 

// 1. Obtém e valida o ID da receita da URL
$idReceita = isset($_GET['r']) && is_numeric($_GET['r']) ? (int)$_GET['r'] : 0;

if ($idReceita === 0) {
    $msgErro = 'ID da receita não especificado ou inválido na URL.';
} 
// 2. Tenta conectar e buscar dados no banco
else if (isset($conexao) && !$conexao->connect_error) {
    
    // SQL para selecionar TODOS os detalhes.
    $sql = "SELECT nomeReceita, ingredientes, modoPreparo, tempoMedio, dificuldade, utensilios, urlFoto 
            FROM receita 
            WHERE idReceita = ?";
    
    try {
        // Usa Prepared Statement para busca segura
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $idReceita);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows === 1) {
            $receita = $resultado->fetch_assoc();
            
            // Processa Ingredientes e Modo de Preparo, quebrando por linha e removendo itens vazios
            if (!empty($receita['ingredientes'])) {
                $ingredientes_array = array_filter(
                    array_map('trim', explode("\n", $receita['ingredientes']))
                );
            }

            if (!empty($receita['modoPreparo'])) {
                $preparo_array = array_filter(
                    array_map('trim', explode("\n", $receita['modoPreparo']))
                );
            }
            
            // Define o texto dos utensílios
            if (!empty($receita['utensilios'])) {
                $utensilios_texto = $receita['utensilios'];
            }

        } else {
            $msgErro = "Receita não encontrada com o ID: " . $idReceita;
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $msgErro = "Erro na consulta ao banco de dados: " . $e->getMessage();
    }
} else {
    $msgErro = 'Erro de conexão com o banco de dados. Verifique o arquivo conexao.php.';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title><?= $receita ? htmlspecialchars($receita['nomeReceita']) : 'Receita Indisponível' ?></title>
    <link rel="icon" href="img/favicon.png" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        /* CSS Base */
        body { font-family: 'Roboto', sans-serif; background: #f9f5f0; margin: 0; padding: 0; color: #333; }
        header { background: #f39200; color: #fff; padding: 18px; text-align: center; }
        header h1 { margin: 0; font-size: 1.7rem; }
        .container { max-width: 980px; margin: 20px auto; padding: 20px; }
        .back-btn { display: inline-block; padding: 8px 14px; background: #f39200; color: #fff; font-weight: 700; border-radius: 10px; text-decoration: none; margin-bottom: 16px; }

        /* ---------- IMAGEM PRINCIPAL (Com Proporção 2:1 no desktop) ---------- */
        .img-container {
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.10);
            
            /* Define a proporção 2:1 (Altura = 50% da Largura) */
            position: relative;
            padding-bottom: 50%; 
            height: 0; 
        }

        .img-container img {
            /* Garante que a imagem preencha o container proporcional */
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            
            object-fit: cover; 
            /* Garante que o centro da foto (o prato) não seja cortado */
            object-position: center center; 
            
            /* Tenta forçar o navegador a usar a melhor qualidade/nitidez */
            image-rendering: optimizeQuality; 
        }
        /* -------------------------------------------------------------------------- */


        /* Meta Dados */
        .recipe-meta { display: flex; justify-content: flex-end; align-items: center; gap: 12px; font-size: 0.95rem; color: #555; margin-bottom: 18px; }

        /* Utensílios */
        .utensilios { background: #fff; padding: 16px; border-radius: 12px; margin-bottom: 18px; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06); }
        .utensilios h3 { color: #f39200; margin: 0 0 10px; }
        .utensilios-grid { display: flex; flex-wrap: wrap; gap: 14px; }
        .utensilios-grid p { color: #555; margin: 0; white-space: pre-line; } 

        /* Ingredientes e Preparo */
        .info-container { display: flex; gap: 18px; }
        .info-box { flex: 1; background: #fff; padding: 18px; border-radius: 12px; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06); }
        .info-box h3 { color: #f39200; margin-top: 0; }
        .info-box ul, .info-box ol { padding-left: 18px; margin-top: 8px; }
        .error-message { background: #ffe6e6; color: #b00020; border: 1px solid #ffcccc; padding: 15px; border-radius: 8px; margin-top: 20px; }
        
        /* Responsividade */
        @media(max-width:820px) {
            .info-container { flex-direction: column; }
            /* Muda a proporção para 3:2 em telas menores (mais alta) */
            .img-container {
                padding-bottom: 66.66%; 
            }
        }
    </style>
</head>

<body>

    <header>
        <h1 id="tituloReceita"><?= $receita ? htmlspecialchars($receita['nomeReceita']) : 'Receita Indisponível' ?></h1>
    </header>

    <div class="container">

        <a href="receitas.php" class="back-btn">← Voltar</a>

        <?php if ($msgErro): ?>
            <div class="error-message">
                Erro ao carregar a receita: <?= htmlspecialchars($msgErro) ?>
            </div>
            
        <?php elseif ($receita): ?>
            <div class="img-container">
                <img id="imagem" 
                     src="<?= htmlspecialchars($receita['urlFoto']) ?>" 
                     alt="Imagem da receita <?= htmlspecialchars($receita['nomeReceita']) ?>"
                     onerror="this.onerror=null;this.src='imgCategorias/default.jpg';" 
                >
            </div>

            <div class="recipe-meta">
                <span id="tempo"><?= htmlspecialchars($receita['tempoMedio']) ?></span> • <span id="dificuldade"><?= htmlspecialchars($receita['dificuldade']) ?></span>
            </div>

            <div class="utensilios">
                <h3>Utensílios:</h3>
                <div class="utensilios-grid" id="listaUtensilios">
                    <p><?= nl2br(htmlspecialchars($utensilios_texto)) ?></p> 
                </div>
            </div>

            <div class="info-container">
                <div class="info-box">
                    <h3>Ingredientes:</h3>
                    <ul id="ingredientes">
                        <?php if (!empty($ingredientes_array)): ?>
                            <?php foreach ($ingredientes_array as $item): ?>
                                <li><?= htmlspecialchars($item) ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Nenhum ingrediente listado.</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="info-box">
                    <h3>Modo de preparo:</h3>
                    <ol id="preparo">
                        <?php if (!empty($preparo_array)): ?>
                            <?php foreach ($preparo_array as $passo): ?>
                                <li><?= htmlspecialchars($passo) ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Não foi possível carregar o modo de preparo.</li>
                        <?php endif; ?>
                    </ol>
                </div>
            </div>
        
        <?php endif; ?>
    </div>
</body>
</html>