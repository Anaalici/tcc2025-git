<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user/user.css">
    <title>Cadastro - Receitas de Mestre</title>
</head>
<body>
    
<div class="tela">
    <section class="lado-esquerdo">
        <h1 class="h2-cad">Sign up</h1>

        <div class="social-icons">
            <img src="../user/userImg/facebook.png">
            <img src="../user/userImg/google.png">
            <img src="../user/userImg/linkedin.png">
        </div>

        <div class="inputs">
        <form class="formulario" method="POST" action="cadastro.php">
                <input class="inputLogin" type="text" id="userCad" name="usuario" placeholder="Usuário" required>

                <input class="inputLogin" type="email" id="emailCad" name="emailCadastro" placeholder="E-mail" required>

                <input class="inputLogin" type="password" id="senhaCad" name="password" placeholder="Senha" required>
        

                    <div class="EsqueciS">
                        <input type="checkbox" id="aceitarTermos">
                        
                        <label for="aceitarTermos" id="labelSenha">Li e aceito o <a href="../user/termos.php">Termo de Uso</a></label> 
                        <a class="senha" href="#">Esqueci senha</a>
                    </div>
            <button class="btn">Cadastrar</button>

            <p class="cadastro-conta">Já tem uma conta? <a href="../user/login.php" class="cadastro">Entrar</a></p>
        </form>
        </div>
    </section>

    <section class="lado-direito">
        <div class="fundo-laranja"></div>
        <img src="../user/userImg/cadastro.png" class="img-cadastro">
    </section>
</div>

    <script>
document.addEventListener("DOMContentLoaded", () => {
    const formulario = document.querySelector(".formulario");
    const aceitarTermos = document.getElementById("aceitarTermos");

    formulario.addEventListener("submit", (e) => {
        if (!aceitarTermos.checked) {
            e.preventDefault();
            alert("Você precisa aceitar os Termos de Uso para continuar.");
        }
    });
});
</script>

</body>
</html>