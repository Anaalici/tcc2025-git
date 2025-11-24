<?php
include '../conexao.php';

$token = $_GET['token'] ?? '';
$user_id = null;
$mensagem = "";

if (empty($token)) {
    $mensagem = "Token de redefinição não fornecido. Por favor, utilize o link completo enviado por e-mail.";
} else {
    $sql_check_token = "SELECT idUsuario FROM usuario WHERE tokenRedefinicao = ? AND expiracaoToken > NOW()";
    $stmt_check_token = $conexao->prepare($sql_check_token);

    if ($stmt_check_token) {
        $stmt_check_token->bind_param("s", $token);
        $stmt_check_token->execute();
        $result_check_token = $stmt_check_token->get_result();

        if ($result_check_token->num_rows > 0) {
            $user = $result_check_token->fetch_assoc();
            $user_id = $user['idUsuario'];

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nova_senha'])) {
                $nova_senha = $_POST['nova_senha'];
                $confirma_senha = $_POST['confirma_senha'];
                
                if ($nova_senha !== $confirma_senha) {
                    $mensagem = "As senhas não coincidem. Tente novamente.";
                } elseif (strlen($nova_senha) < 8) { 
                    $mensagem = "A senha deve ter pelo menos 8 caracteres.";
                } else {
                    if (!empty($nova_senha)) {
                        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                        
                        $sql_update_senha = "UPDATE usuario SET senha = ?, tokenRedefinicao = NULL, expiracaoToken = NULL WHERE idUsuario = ?";
                        $stmt_update_senha = $conexao->prepare($sql_update_senha);
                        
                        if ($stmt_update_senha) {
                            $stmt_update_senha->bind_param("si", $senha_hash, $user_id); 
                            
                            if ($stmt_update_senha->execute()) {
                                $mensagem = "Sua senha foi redefinida com sucesso! Você já pode <a href='login.php'>fazer login</a>.";
                                $user_id = null;
                            } else {
                                $mensagem = "Erro ao atualizar a senha: " . $stmt_update_senha->error;
                            }
                            $stmt_update_senha->close();
                        } else {
                            $mensagem = "Erro interno na preparação da atualização.";
                        }
                    } else {
                         $mensagem = "A nova senha não pode ser vazia.";
                    }
                }
            }
        } else {
            $mensagem = "Link de redefinição inválido ou expirado. Por favor, solicite um novo.";
        }
        $stmt_check_token->close();
    } else {
        $mensagem = "Erro interno do servidor ao verificar o token.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Receita de Mestre</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-...seu-hash-aqui..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #FFF8F0; color: #333; }
        .card { background: #FFFFFF; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.12); width: 400px; max-width: 90%; padding: 40px 30px; position: relative; }
        h2 { text-align: center; color: #D2691E; margin-bottom: 15px; font-weight: 700; }
        p { text-align: center; font-size: 14px; color: #555; margin-bottom: 30px; line-height: 1.5; }
        .input-group { position: relative; margin-bottom: 20px; }
        
        .input-group input { 
            width: 100%; 
            padding: 14px 45px 14px 16px;
            border-radius: 12px; 
            border: 1px solid #CCC; 
            font-size: 14px; 
            transition: border-color 0.3s; 
        }
        .input-group input:focus { outline: none; border-color: #FF8C42; box-shadow: 0 0 0 2px rgba(255,140,66,0.2); }
        
        
        .toggle-password {
            position: absolute;
            right: 15px; 
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #D2691E;
            font-size: 16px;
            z-index: 10;
        }

        button { width: 100%; padding: 14px; border: none; border-radius: 12px; background-color: #FF8C42; color: white; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.3s, transform 0.2s; }
        button:hover { background-color: #e47735; transform: translateY(-2px); }
        .link { display: block; text-align: center; margin-top: 18px; font-size: 14px; color: #D2691E; text-decoration: none; transition: color 0.3s; }
        .link:hover { color: #FF8C42; }
    </style>
</head>
<body>

<div class="card">
    <h2>Redefinir Senha</h2>
    <p>**<?php echo $mensagem; ?>**</p>

    <?php if ($user_id): ?>
    <form method="POST">
        <div class="input-group">
            <input type="password" name="nova_senha" id="nova_senha" placeholder="Nova Senha (mín. 8 caracteres)" required>
            <span toggle="#nova_senha" class="fas fa-eye toggle-password" onclick="mostrarOcultarSenha(this)"></span>
        </div>
        
        <div class="input-group">
            <input type="password" name="confirma_senha" id="confirma_senha" placeholder="Confirme a Nova Senha" required>
            <span toggle="#confirma_senha" class="fas fa-eye toggle-password" onclick="mostrarOcultarSenha(this)"></span>
        </div>
        
        <button type="submit">Atualizar Senha</button>
    </form>
    <?php endif; ?>

    <a class="link" href="login.php">Voltar para o login</a>
</div>

<script>
    function mostrarOcultarSenha(toggle) {
        var inputId = toggle.getAttribute('toggle').substring(1);
        var input = document.getElementById(inputId);

        if (input.type === "password") {
            input.type = "text";
            toggle.classList.remove("fa-eye");
            toggle.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            toggle.classList.remove("fa-eye-slash");
            toggle.classList.add("fa-eye");
        }
    }
</script>
</body>
</html>