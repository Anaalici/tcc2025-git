document.addEventListener('DOMContentLoaded', () => {
    
    const cpfInput = document.getElementById('cpf');
    const contatoInput = document.getElementById('contato');
    const senhaInput = document.getElementById('senha');
    const form = document.getElementById('cadastroForm');

    function maskCPF(value) {
        return value
            .replace(/\D/g, '') 
            .replace(/(\d{3})(\d)/, '$1.$2') 
            .replace(/(\d{3})(\d)/, '$1.$2') 
            .replace(/(\d{3})(\d{1,2})$/, '$1-$2') 
            .slice(0, 14); 
    }

    function maskContato(value) {
        value = value.replace(/\D/g, ''); 
        if (value.length > 11) { value = value.slice(0, 11); }
        value = value.replace(/^(\d{2})(\d)/g, '($1) $2'); 
        if (value.length > 10) { 
             value = value.replace(/(\d{5})(\d)/, '$1-$2'); 
        } else if (value.length > 6) {
             value = value.replace(/(\d{4})(\d)/, '$1-$2');
        }
        return value;
    }

    if (cpfInput) { cpfInput.addEventListener('input', (event) => { event.target.value = maskCPF(event.target.value); }); }
    if (contatoInput) { contatoInput.addEventListener('input', (event) => { event.target.value = maskContato(event.target.value); }); }

    if (form) {
        form.addEventListener('submit', (event) => {
            let isValid = true;

            if (senhaInput && senhaInput.value.length < 8) {
                alert('A senha deve ter no mínimo 8 dígitos. Por favor, corrija.');
                senhaInput.focus();
                isValid = false;
            }
            
            const termosCheckbox = document.getElementById('termos');
            if (isValid && termosCheckbox && !termosCheckbox.checked) {
                alert('Você deve ler e aceitar o Termo de Uso para se cadastrar.');
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); 
            }
        });
    }

});

window.mostrarOcultarSenha = function(toggle) {
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