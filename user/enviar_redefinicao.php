<?php
include '../conexao.php'; 

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$base_url = "http://localhost/tccatual/tcc2025-git/user/"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['email'])) {
    
    $email = trim($_POST['email']);
    $mensagem = "";
    
    $sql_check = "SELECT idUsuario FROM usuario WHERE email = ?";
    $stmt_check = $conexao->prepare($sql_check);

    if ($stmt_check) {
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $user = $result_check->fetch_assoc();
            $idUsuario = $user['idUsuario'];

            $token = bin2hex(random_bytes(32)); 
            $expiracao = date('Y-m-d H:i:s', time() + 3600); 

            $sql_update = "UPDATE usuario SET tokenRedefinicao = ?, expiracaoToken = ? WHERE idUsuario = ?";
            $stmt_update = $conexao->prepare($sql_update);
            
            if ($stmt_update) {
                $stmt_update->bind_param("ssi", $token, $expiracao, $idUsuario);
                $stmt_update->execute();
                $stmt_update->close();

                $redefinicao_url = $base_url . "redefinir_senha.php?token=" . $token;
                
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com'; 
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = 'gabrihel.camargo1234@gmail.com'; 
                    $mail->Password   = 'bwonsplblguffszz'; 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                    $mail->Port       = 465; 
                    $mail->CharSet = 'UTF-8';
                    
                    $mail->setFrom('noreply@receitademestre.com', 'Receita de Mestre');
                    $mail->addAddress($email);     

                    $mail->isHTML(true);                                  
                    $mail->Subject = 'Redefinicao de Senha - Receita de Mestre';
                    
                    $mail->Body    = "
                        <h2>Redefinicao de Senha</h2>
                        <p>Olá,</p>
                        <p>Você solicitou a redefinição de sua senha. Clique no link abaixo para criar uma nova senha:</p>
                        <p><a href='{$redefinicao_url}' style='color: #FF8C42; text-decoration: none; font-weight: bold;'>Redefinir Minha Senha</a></p>
                        <p>Este link é válido por 1 hora.</p>
                        <p>Se você não solicitou esta redefinição, ignore este e-mail.</p>
                        <hr>
                        <p style='font-size: 10px;'>Link direto: {$redefinicao_url}</p>
                    ";
                    $mail->AltBody = "Clique no link para redefinir sua senha: " . $redefinicao_url; 

                    $mail->send();
                    
                    $mensagem = "Se o e-mail estiver cadastrado, um link de redefinição foi enviado. Verifique sua caixa de entrada e spam.";

                } catch (Exception $e) {
                    $mensagem = "Não foi possível enviar o link de redefinição. Erro do Servidor de Mailer: {$mail->ErrorInfo}";
                }

            } else {
                $mensagem = "Erro interno ao preparar a atualização do token.";
            }
        } else {
            $mensagem = "Se o e-mail estiver cadastrado, um link de redefinição foi enviado. Verifique sua caixa de entrada e spam.";
        }
        $stmt_check->close();
    }
} else {
    $mensagem = "Por favor, insira um endereço de e-mail válido.";
}

echo "<h2>Resultado da Solicitação</h2><p>" . $mensagem . "</p>";
echo "<a href='redefinir_senha.php'>Voltar</a>";
?>