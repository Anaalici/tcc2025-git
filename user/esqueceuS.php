<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recuperar Senha - Receita de Mestre</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Inter', sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #FFF8F0;
        color: #333;
    }

    .card {
        background: #FFFFFF;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        width: 400px;
        max-width: 90%;
        padding: 40px 30px;
        position: relative;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    h2 {
        text-align: center;
        color: #D2691E;
        margin-bottom: 15px;
        font-weight: 700;
    }

    p {
        text-align: center;
        font-size: 14px;
        color: #555;
        margin-bottom: 30px;
        line-height: 1.5;
    }

    .input-group {
        position: relative;
        margin-bottom: 20px;
    }

    .input-group input {
        width: 100%;
        padding: 14px 16px;
        border-radius: 12px;
        border: 1px solid #CCC;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .input-group input:focus {
        outline: none;
        border-color: #FF8C42;
        box-shadow: 0 0 0 2px rgba(255,140,66,0.2);
    }

    .input-group i {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #FF8C42;
        font-size: 18px;
    }

    button {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 12px;
        background-color: #FF8C42;
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s, transform 0.2s;
    }

    button:hover {
        background-color: #e47735;
        transform: translateY(-2px);
    }

    .link {
        display: block;
        text-align: center;
        margin-top: 18px;
        font-size: 14px;
        color: #D2691E;
        text-decoration: none;
        transition: color 0.3s;
    }

    .link:hover {
        color: #FF8C42;
    }

    @media (max-width: 450px) {
        .card {
            padding: 30px 20px;
        }
    }
</style>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="card">
    <h2>Recuperar Senha</h2>
    <p>Informe o e-mail cadastrado e enviaremos um link para você redefinir sua senha.</p>

    <form action="enviar_redefinicao.php" method="POST">
    <div class="input-group">
        <input type="email" name="email" placeholder="Digite seu e-mail" required>
        </div>
    <button type="submit">Enviar Link</button>
    </form>

    <a class="link" href="../user/login.php">Voltar para o login</a>
</div>

</body>
</html>
