function togglePasswordVisibilityCheckbox() {
        // Busca os elementos pelo ID (é crucial que esses IDs estejam no seu HTML)
        const senhaInput = document.getElementById('senha');
        const checkbox = document.getElementById('mostrarSenha');
        const label = document.getElementById('labelSenha');

        if (checkbox.checked) {
            // Se marcado: MOSTRAR SENHA
            senhaInput.type = 'text'; 
            label.textContent = 'Esconder Senha 🙈'; 
        } else {
            // Se desmarcado: ESCONDER SENHA
            senhaInput.type = 'password'; 
            label.textContent = 'Mostrar Senha 👁️'; 
        }
    }