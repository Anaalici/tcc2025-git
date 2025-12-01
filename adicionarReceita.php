<?php
// --- INCLUI O ARQUIVO DE CONEXÃO (MySQLi) ---
// Assume que este arquivo cria a variável $conexao com a conexão ao MySQLi.
include 'conexao.php'; 
// ------------------------------------------

// Variáveis de upload (Ajuste conforme seu ambiente)
$upload_dir = 'imagens_receitas/'; 
// CRUCIAL: AJUSTE ESTA URL para o caminho público real no seu XAMPP.
// Exemplo: 'http://localhost/tccatual/tcc2025/git/imagens_receitas/'; 
$base_url_imagens = 'http://seuservidor.com/' . $upload_dir; // <-- AJUSTAR AQUI

$msg_status = '';
$msg_cor = '';
$form_data = []; // Array para manter dados preenchidos em caso de erro

// ---------------------------------------------------
// LÓGICA DE PROCESSAMENTO DO FORMULÁRIO (POST)
// ---------------------------------------------------
// Verifica se a conexão MySQLi está ativa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($conexao) && !$conexao->connect_error) {
    
    // Coleta os dados do formulário (POST)
    $nomeReceita = trim($_POST['nome'] ?? '');
    $tempoMedio = trim($_POST['tempo'] ?? '');
    $dificuldade = trim($_POST['dificuldade'] ?? '');
    $idCategoriaRec = trim($_POST['categoria'] ?? '');
    $utensilios = trim($_POST['utensilios'] ?? ''); 
    $ingredientes = trim($_POST['ingredientes'] ?? '');
    $modoPreparo = trim($_POST['preparo'] ?? '');

    // ID do usuário criador (MUITO IMPORTANTE: Substitua '1' pela ID real da sessão/login)
    $idUsuario = 1; 

    // Armazena dados para repopular o formulário em caso de erro
    $form_data = $_POST;

    // 2.1. Validação dos Campos OBRIGATÓRIOS
    if (empty($nomeReceita) || empty($tempoMedio) || empty($dificuldade) || empty($idCategoriaRec) || empty($ingredientes) || empty($modoPreparo) || empty($_FILES['foto']['name'])) {
        $msg_status = 'Por favor, preencha todos os campos obrigatórios (*), incluindo a foto.';
        $msg_cor = 'red';
    } else {
        $urlFoto = null;

        // 2.2. Processamento da Imagem (Upload)
        $file = $_FILES['foto'];
        if ($file['error'] === UPLOAD_ERR_OK) {
            
            // Tenta criar a pasta de destino se não existir (resolve "No such file or directory")
            if (!is_dir($upload_dir)) {
                if (!mkdir($upload_dir, 0755, true)) {
                    $msg_status = 'Erro grave: A pasta de upload não existe e não pôde ser criada. Verifique as permissões.';
                    $msg_cor = 'red';
                }
            }

            if ($msg_cor !== 'red') {
                $extensao = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $nome_seguro = preg_replace("/[^a-zA-Z0-9]+/", "-", strtolower($nomeReceita));
                $nome_arquivo = $nome_seguro . '-' . time() . '.' . $extensao;
                $caminho_completo = $upload_dir . $nome_arquivo; 
                
                // move_uploaded_file()
                if (move_uploaded_file($file['tmp_name'], $caminho_completo)) {
                    $urlFoto = $base_url_imagens . $nome_arquivo;
                } else {
                    $msg_status = 'Erro ao salvar o arquivo de imagem no servidor. Verifique as permissões da pasta "imagens_receitas".';
                    $msg_cor = 'red';
                }
            }
        }
        
        // 2.3. Inserção no Banco de Dados (Usando MySQLi Prepared Statements)
        if ($msg_cor !== 'red') {
            
            // --- COMANDO SQL FINAL: SEM descricaoReceita ---
            // As colunas de entrada são nome, ingredientes, preparo, tempo, urlFoto, idUsuario, idCategoriaRec
            $sql = "INSERT INTO receita (
                nomeReceita, ingredientes, modoPreparo, tempoMedio, 
                urlFoto, 
                idUsuario, 
                idCategoriaRec
            ) VALUES (
                ?, ?, ?, ?, 
                ?, ?, ?
            )";

            try {
                $stmt = $conexao->prepare($sql);

                // Tipos de dados (7 parâmetros): 5 strings (s) + 2 integers (i)
                $stmt->bind_param("sssssii", 
                    $nomeReceita, 
                    $ingredientes, 
                    $modoPreparo, 
                    $tempoMedio, 
                    $urlFoto, 
                    $idUsuario, 
                    $idCategoriaRec
                );

                // Executa a query
                if ($stmt->execute()) {
                    $msg_status = "Receita salva com sucesso! ID: " . $stmt->insert_id . ".";
                    $msg_cor = 'green';
                    $form_data = []; // Limpa o formulário após o sucesso
                } else {
                    $msg_status = "Erro ao inserir no banco: " . $stmt->error;
                    $msg_cor = 'red';
                }
                $stmt->close();

            } catch (Exception $e) {
                $msg_status = "Erro inesperado: " . $e->getMessage();
                $msg_cor = 'red';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Adicionar Receita</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
/* --- ESTILOS CSS (MANTIDOS) --- */
:root{--orange:#f39200;--bg:#f9f5f0;--muted:#555;}
html, body {height: 100%; margin: 0; font-family: Roboto, sans-serif; background: var(--bg); color: #222; overflow-x: hidden; max-width: 100%;}
header{background:var(--orange); color:#fff; padding:1rem 1.25rem; display:flex; align-items:center; justify-content:space-between;}
header h1{margin:0; font-size:1.25rem;}
.close-btn{background:transparent; border:0; color:#fff; font-weight:700; font-size:1rem; cursor:pointer;}
main {padding: 2rem 2.5rem; width: 100%; max-width: 100%; box-sizing: border-box;}
form{width:100%; max-width:100%;}
.row {display: flex; gap: 2rem; margin-bottom: 1rem; width: 100%; flex-wrap: wrap; box-sizing: border-box;}
.col{flex:1; min-width:0;}
label{display:block; font-size:0.875rem; margin-bottom:0.35rem; color:var(--muted);}
input[type="text"], input[type="file"], select, textarea {width:100%; padding:0.6rem 0.75rem; border-radius:8px; border:1px solid #ccc; background:#fff; font-size:0.95rem;}
textarea{min-height:120px; resize:vertical; padding-top:0.75rem;}
.small{font-size:0.85rem; color:#888; margin-top:0.35rem;}
.photo-preview{width:100%; height:240px; border-radius:10px; background:linear-gradient(180deg,#f5f3f1,#eee9e5); display:flex; align-items:center; justify-content:center; overflow:hidden;}
.photo-preview img{width:100%; height:100%; object-fit:cover;}
.actions{display:flex; gap:0.75rem; justify-content:flex-end; margin-top:1.5rem;}
.btn{padding:0.7rem 1rem; border-radius:10px; border:0; font-weight:700; cursor:pointer;}
.btn.secondary{background:#ddd; color:#222;}
.btn.primary{background:var(--orange); color:#fff;}
.error-msg {border-left: 5px solid; padding: 0.75em; margin-top: 1.25em; border-radius: 0.5em; }
.msg-green {background: #dcffdc; border-color: #2ba82b; color: #2ba82b;}
.msg-red {background: #ffcccc; border-color: #b00020; color: #b00020;}
@media(max-width:820px){.row{flex-direction:column;}.photo-preview{height:180px;}}
</style>
</head>

<body>

<header>
    <h1>Adicionar Receita</h1>
    <button class="close-btn" onclick="location.href='index.html'">Fechar ✕</button>
</header>

<main>
    <form id="formReceita" method="POST" action="" enctype="multipart/form-data" autocomplete="off" novalidate>

        <div class="row">
            <div class="col" style="max-width:340px">
                <label for="foto">Foto da receita *</label>
                <div class="photo-preview" id="previewBox">
                    <span id="previewPlaceholder" style="color:#7b7b7b">Nenhuma imagem escolhida</span>
                    <img id="previewImg" src="" alt="" style="display:none">
                </div>
                <input id="foto" name="foto" type="file" accept="image/*" required style="margin-top:0.6rem">
                <div class="small">Escolha uma imagem.</div>
                <div class="error" id="errFoto" style="display:none;color:#b00020"></div>
            </div>

            <div class="col">
                <label for="nome">Nome da receita *</label>
                <input id="nome" name="nome" type="text" placeholder="Ex: Bolo de Cenoura" value="<?= htmlspecialchars($form_data['nome'] ?? '') ?>">

                <div class="row" style="margin-top:0.75rem">
                    <div class="col">
                        <label for="tempo">Tempo *</label>
                        <input id="tempo" name="tempo" type="text" placeholder="40 min" value="<?= htmlspecialchars($form_data['tempo'] ?? '') ?>">
                    </div>
                    <div class="col" style="max-width:200px">
                        <label for="dificuldade">Dificuldade *</label>
                        <select id="dificuldade" name="dificuldade">
                            <option value="">Selecione</option>
                            <option value="Fácil" <?= ($form_data['dificuldade'] ?? '') == 'Fácil' ? 'selected' : '' ?>>Fácil</option>
                            <option value="Médio" <?= ($form_data['dificuldade'] ?? '') == 'Médio' ? 'selected' : '' ?>>Médio</option>
                            <option value="Difícil" <?= ($form_data['dificuldade'] ?? '') == 'Difícil' ? 'selected' : '' ?>>Difícil</option>
                        </select>
                    </div>
                </div>

                <div class="row" style="margin-top:0.75rem">
                    <div class="col">
                        <label for="categoria">Categoria *</label>
                        <select id="categoria" name="categoria">
                            <option value="">Selecione</option>
                            <option value="1" <?= ($form_data['categoria'] ?? '') == '1' ? 'selected' : '' ?>>Vegana</option>
                            <option value="2" <?= ($form_data['categoria'] ?? '') == '2' ? 'selected' : '' ?>>Lanches</option>
                            <option value="3" <?= ($form_data['categoria'] ?? '') == '3' ? 'selected' : '' ?>>Massa Doce</option>
                            <option value="4" <?= ($form_data['categoria'] ?? '') == '4' ? 'selected' : '' ?>>Japonesa</option>
                        </select>
                    </div>

                    <div style="width:140px;display:flex;align-items:flex-end">
                        <button type="button" class="btn secondary" style="width:100%">Prévia</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="utensilios">Utensílios</label>
                <textarea id="utensilios" name="utensilios" placeholder="Não será salvo no BD, apenas para sua referência"><?= htmlspecialchars($form_data['utensilios'] ?? '') ?></textarea>
            </div>

            <div class="col">
                <label for="ingredientes">Ingredientes *</label>
                <textarea id="ingredientes" name="ingredientes"><?= htmlspecialchars($form_data['ingredientes'] ?? '') ?></textarea>
                <div class="error" id="errIngredientes" style="display:none;color:#b00020"></div>
            </div>
        </div>

        <label for="preparo">Modo de preparo *</label>
        <textarea id="preparo" name="preparo"><?= htmlspecialchars($form_data['preparo'] ?? '') ?></textarea>
        <div class="error" id="errPreparo" style="display:none;color:#b00020"></div>

        <div class="actions">
            <button type="button" class="btn secondary" onclick="location.href='index.html'">Cancelar</button>
            <button class="btn primary" type="submit">Salvar Receita</button>
        </div>

        <?php if (!empty($msg_status)): ?>
            <div id="msg" class="error-msg msg-<?= $msg_cor ?>" style="margin-top:1rem; display:block;">
                <?= $msg_status ?>
            </div>
        <?php endif; ?>
    </form>
</main>

<script>
    // --- CÓDIGO JAVASCRIPT: Pré-visualização da Imagem (MANTIDO) ---
    document.getElementById('foto').addEventListener('change', function() {
        const file = this.files[0];
        const previewImg = document.getElementById('previewImg');
        const previewPlaceholder = document.getElementById('previewPlaceholder');

        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                previewPlaceholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            previewImg.style.display = 'none';
            previewPlaceholder.style.display = 'block';
        }
    });
</script>

</body>
</html>