document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const cadastreSeBtn = document.querySelector('.cadastre-se span');
    
    // Seleciona a mensagem de erro que vem do PHP
    const phpErrorMessage = document.querySelector('.login-error-message');

    // Função para limpar a mensagem de erro quando o usuário começa a corrigir
    function clearErrorOnChange() {
        if (phpErrorMessage) {
            phpErrorMessage.style.display = 'none';
        }
        // Remove o listener para não executar desnecessariamente de novo
        emailInput.removeEventListener('input', clearErrorOnChange);
        passwordInput.removeEventListener('input', clearErrorOnChange);
    }

    // Se uma mensagem de erro do PHP existir, adiciona o evento para limpá-la
    if (phpErrorMessage) {
        emailInput.addEventListener('input', clearErrorOnChange);
        passwordInput.addEventListener('input', clearErrorOnChange);
    }

    // Lógica para o botão "Cadastre-se"
    if (cadastreSeBtn) {
        cadastreSeBtn.addEventListener('click', function() {
            window.location.href = 'cadastro.php';
        });
    }

    // Não adicionamos um listener de 'submit' para não interferir com o PHP.
    // O formulário será enviado normalmente.
});
