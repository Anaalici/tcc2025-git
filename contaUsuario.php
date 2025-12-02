<?php
// Certifique-se de que a sessão seja iniciada se você for usar $_SESSION['idUsuario'] em produção.
// session_start(); 

// --- CONFIGURAÇÃO E CONEXÃO ---

// 1. INCLUI O ARQUIVO DE CONEXÃO
// Seu arquivo conexao.php (que usa mysqli) cria a variável $conexao
include 'conexao.php'; 

// 2. CONFIGURAÇÃO DE UPLOAD
$upload_dir = 'perfil_fotos/'; 
// CRUCIAL: Ajuste a URL abaixo se o seu projeto estiver em uma pasta diferente no XAMPP!
// Esta URL deve ser o caminho público para a pasta de fotos.
$base_url_imagens = 'http://localhost/tccatual/tcc2025-git/perfil_fotos/'; 

// 3. VARIÁVEIS DE ESTADO
$msg_status = '';
$msg_cor = '';
$USER_ID = 1; // Mantenha 1 para teste. Use $_SESSION['idUsuario'] em produção.
$dados_usuario = null;
$foto_atual_url = 'https://via.placeholder.com/140'; // URL padrão (placeholder)

// ---------------------------------------------------
// 4. LÓGICA DE PROCESSAMENTO DO FORMULÁRIO (UPDATE - MySQLi)
// ---------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($conexao) && !$conexao->connect_error) {
    
    // Escapa a Bio para segurança
    $bio_nova = $conexao->real_escape_string(trim($_POST['userBio'] ?? ''));
    $urlFoto_upload = null; 

    // --- Processamento da Imagem (Upload) ---
    if (!empty($_FILES['photoInput']['name']) && $_FILES['photoInput']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['photoInput'];
        
        $extensao = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $nome_seguro = 'perfil-' . $USER_ID . '-' . time() . '.' . $extensao;
        $caminho_completo = $upload_dir . $nome_seguro; 

        // Tenta criar a pasta se não existir (resolve o erro 'No such file')
        if (!is_dir($upload_dir)) {
            // Tenta criar com permissões 0755
            if (!mkdir($upload_dir, 0755, true)) {
                 $msg_status = 'Erro grave: A pasta de upload não pôde ser criada. Verifique permissões.';
                 $msg_cor = 'red';
            }
        }
        
        // move_uploaded_file()
        if ($msg_cor !== 'red' && move_uploaded_file($file['tmp_name'], $caminho_completo)) {
            // Salva a URL completa usando o nome da coluna correta (fotoPerfil)
            $urlFoto_upload = $conexao->real_escape_string($base_url_imagens . $nome_seguro);
        } else if ($msg_cor !== 'red') {
            $msg_status = 'Erro ao salvar o arquivo de imagem. Verifique as permissões da pasta "perfil_fotos".';
            $msg_cor = 'red';
        }
    }

    // --- Preparar e Executar UPDATE ---
    if ($msg_cor !== 'red') {
        try {
            if ($urlFoto_upload) {
                // Atualiza a foto (coluna fotoPerfil) e a bio.
                $sql = "UPDATE usuario SET bio = '{$bio_nova}', fotoPerfil = '{$urlFoto_upload}' WHERE idUsuario = {$USER_ID}";
                $conexao->query($sql);
                
                // 🎯 CORREÇÃO DE EXIBIÇÃO: Atualiza a variável de foto imediatamente após o sucesso
                $foto_atual_url = $urlFoto_upload; 
                
                $msg_status = "Foto e Bio atualizadas com sucesso! ❤️";
            } else {
                // Apenas a bio.
                $sql = "UPDATE usuario SET bio = '{$bio_nova}' WHERE idUsuario = {$USER_ID}";
                $conexao->query($sql);
                $msg_status = "Bio atualizada com sucesso! ❤️";
            }
            $msg_cor = 'green';
        } catch (Exception $e) {
            $msg_status = "Erro ao atualizar dados: " . $conexao->error;
            $msg_cor = 'red';
        }
    }
}

// ---------------------------------------------------
// 5. LÓGICA DE CARREGAMENTO DE DADOS (SELECT - MySQLi)
// ---------------------------------------------------
// Se o POST falhar, ou se for a primeira vez, carrega os dados do banco
if (isset($conexao) && !$conexao->connect_error) {
    try {
        // Seleciona as colunas corretas (fotoPerfil e bio)
        $sql = "SELECT nomeUsuario, email, dataNasc, bio, fotoPerfil FROM usuario WHERE idUsuario = {$USER_ID}";
        $resultado = $conexao->query($sql);
        
        if ($resultado && $resultado->num_rows > 0) {
            $dados_usuario = $resultado->fetch_assoc();

            // Puxa a URL da coluna correta
            if (!empty($dados_usuario['fotoPerfil'])) {
                // A foto_atual_url pode ter sido sobrescrita no POST, se não, pega do banco
                $foto_atual_url = htmlspecialchars($dados_usuario['fotoPerfil']);
            }
        } else {
            $msg_status = "Usuário não encontrado.";
            $msg_cor = 'red';
        }
    } catch (Exception $e) {
        $msg_status = "Erro ao carregar dados: " . $conexao->error;
        $msg_cor = 'red';
    }
} else {
    $msg_status = "Erro grave: A conexão com o banco de dados falhou. Verifique 'conexao.php'.";
    $msg_cor = 'red';
}

// Mapeamento seguro para os campos HTML
$nomeUsuario = htmlspecialchars($dados_usuario['nomeUsuario'] ?? '');
$email = htmlspecialchars($dados_usuario['email'] ?? '');
$dataNasc = htmlspecialchars($dados_usuario['dataNasc'] ?? '');
$userBio = htmlspecialchars($dados_usuario['bio'] ?? '');


// ---------------------------------------------------
// 6. ESTRUTURA HTML DA PÁGINA
// ---------------------------------------------------
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Minha Conta</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<style>
/* --- CSS (MANTIDO) --- */
body {margin: 0; font-family: 'Roboto', sans-serif; background: #f9f5f0; color: #333;}
header {background: #f39200; padding: 0.9375em 1.5625em; color: #fff; font-size: 1.125em; font-weight: bold;}
.back-btn {display: inline-block; margin: 1.25em 0 0 1.5625em; background: #f39200; padding: 0.5em 0.875em; border-radius: 0.5em; color: #fff; text-decoration: none; font-weight: bold; transition: .2s;}
.main {padding: 2.5em 5vw;}
h1 {color: #f39200; margin-bottom: 1.875em;}
.profile-row {display: flex; align-items: center; gap: 1.5625em; margin-bottom: 2.1875em;}
.profile-img {width: 8.75em; height: 8.75em; border-radius: 50%; object-fit: cover; background: #ddd; box-shadow: 0 0.25em 0.75em rgba(0,0,0,0.15);}
.upload-box {display: flex; flex-direction: column;}
#photoInput {display: none;}
.upload-btn {background: #f39200; padding: 0.625em 0.875em; color: #fff; border-radius: 0.625em; font-weight: bold; cursor: pointer; margin-top: 0.625em; display: inline-block; transition: .2s;}
.upload-btn:hover {background: #d88000;}
label {font-weight: 600; color: #f39200; margin-top: 1.25em; display: block;}
input, textarea {width: 100%; padding: 0.75em; margin-top: 0.375em; border: 0.0625em solid #ccc; border-radius: 0.625em; background: #fff; font-size: 1em;}
textarea {resize: none; height: 7.5em;}
button {margin-top: 1.875em; background: #f39200; color: #fff; border: none; padding: 0.9375em; border-radius: 0.75em; font-size: 1.0625em; cursor: pointer; width: 14.375em;}
button:hover {background: #d88000;}
.success-msg {border-left: 0.3125em solid; padding: 0.75em; margin-top: 1.25em; border-radius: 0.5em; }
.msg-green {background: #dcffdc; border-color: #2ba82b; color: #2ba82b;}
.msg-red {background: #ffcccc; border-color: #b00020; color: #b00020;}
@media (max-width: 600px) {.profile-row {flex-direction: column; text-align: center;} .profile-img {width: 7.5em; height: 7.5em;}}
</style>
</head>

<body>

<header>
    Minha Conta
</header>

<a href="index.html" class="back-btn">← Voltar</a>

<div class="main">

    <form method="POST" action="" enctype="multipart/form-data">
        
        <?php if (!empty($msg_status)): ?>
            <div id="saveMsg" class="success-msg msg-<?= $msg_cor ?>" style="display:block;">
                <?= htmlspecialchars($msg_status) ?>
            </div>
        <?php endif; ?>

        <div class="profile-row">
            <img id="userPhoto" class="profile-img" src="<?= $foto_atual_url ?>?v=<?= time() ?>" alt="Foto de perfil">
            
            <div class="upload-box"> 
                <label class="upload-btn" for="photoInput">Escolher Foto</label>
                <input type="file" id="photoInput" name="photoInput" accept="image/*">
            </div>
        </div>
        
        <label>Nome Completo</label>
        <input type="text" id="userName" name="userName" value="<?= $nomeUsuario ?>" readonly>

        <label>Email</label>
        <input type="email" id="userEmail" name="userEmail" value="<?= $email ?>" readonly>

        <label>Data de Nascimento</label>
        <input type="date" id="userDataNasc" name="userDataNasc" value="<?= $dataNasc ?>" readonly>

        <label>Bio</label>
        <textarea id="userBio" name="userBio" placeholder="Conte-nos um pouco sobre você..."><?= $userBio ?></textarea>

        <button type="submit">Salvar Alterações</button>

    </form>
</div>

<script>
    // 1. Seleciona o campo de input (onde o arquivo é escolhido) e a imagem de perfil (onde a pré-visualização aparece)
    const photoInput = document.getElementById('photoInput');
    const userPhoto = document.getElementById('userPhoto');

    // 2. Adiciona um "ouvinte de evento" para detectar quando um arquivo é selecionado
    photoInput.addEventListener('change', function(event) {
        // Verifica se o usuário realmente selecionou um arquivo
        if (event.target.files && event.target.files[0]) {
            // Cria um objeto para ler o conteúdo do arquivo
            const reader = new FileReader();

            // 3. Define o que acontece quando o leitor termina de carregar o arquivo
            reader.onload = function(e) {
                // e.target.result contém a Data URL (a imagem codificada)
                // Define o atributo src da imagem para exibir a pré-visualização
                userPhoto.src = e.target.result;
            };

            // 4. Inicia a leitura do arquivo como uma Data URL (formato que o navegador pode exibir)
            reader.readAsDataURL(event.target.files[0]);
        }
    });
</script>
</body>
</html>