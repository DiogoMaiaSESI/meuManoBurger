//O JS só roda depois que o DOM inteiro está feito.
document.addEventListener('DOMContentLoaded', function () {
    const msgErro = document.querySelector('.msg_erro'); 
    const form = document.querySelector('form');
    const senha = document.getElementById('password');
    const confirmarSenha = document.getElementById('confirm_password');
    const inputImagem = document.getElementById("imagemPerfil");
    const previewImagem = document.getElementById("previewImagem");
    const loginLink = document.querySelector('.login-link'); // Seleciona o link "Login"

    if (loginLink) {
        loginLink.addEventListener('click', function() {
            // Redireciona para a página de login
            window.location.href = 'Login.php';
        });
    }

    if (form) {
        form.addEventListener("submit", function (event) {
            // Verifica se as senhas são diferentes
            if (senha.value !== confirmarSenha.value) {
                // 1. IMPEDE o envio do formulário
                event.preventDefault(); 
                
                // 2. Mostra a mensagem de erro e foca no campo
                msgErro.style.display = 'block'; 
                confirmarSenha.focus();
            }
            // 3. Se as senhas forem iguais, o JavaScript NÃO FAZ NADA.
            //    Isso permite que o formulário seja enviado normalmente para o PHP.
        });
    }

    if (inputImagem) {
        inputImagem.addEventListener("change", function () {
            const arquivo = this.files[0];
            if (arquivo) {
                const leitor = new FileReader();

                leitor.addEventListener("load", function () {
                    previewImagem.setAttribute("src", this.result);
                });

                leitor.readAsDataURL(arquivo);
            }
        });
    }
});
