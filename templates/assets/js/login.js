document.addEventListener('DOMContentLoaded', function() {

    // --- LÓGICA DO MODAL DE VERIFICAÇÃO 2FA ---
    const modal = document.getElementById('modal-2fa');
    const submitBtn = document.getElementById('twofa-submit');
    const cancelBtn = document.getElementById('twofa-cancel');
    const codeInput = document.getElementById('twofa-code');
    const errorEl = document.getElementById('twofa-error');

    // Função para abrir o modal
    function openModal() {
        if (!modal) return;
        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
        if (codeInput) codeInput.focus();
    }

    // Função para fechar o modal
    function closeModal() {
        if (!modal) return;
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
        if (errorEl) errorEl.style.display = 'none';
    }

    // Adiciona o evento de clique ao botão "Cancelar"
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function(e) {
            e.preventDefault();
            closeModal();
        });
    }

    // Adiciona o evento de clique ao botão "Verificar e entrar"
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!codeInput || !errorEl) return;

            const code = codeInput.value.trim();
            if (!/^\d{6}$/.test(code) && !/^[A-Z0-9]{8}$/.test(code)) { // Aceita 6 dígitos ou 8 caracteres (recovery code)
                errorEl.textContent = 'Informe um código válido.';
                errorEl.style.display = 'block';
                return;
            }

            submitBtn.disabled = true;
            errorEl.style.display = 'none';

            // Envia para o endpoint da API
            fetch('api.php?action=verify-login-2fa', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ code: code })
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`Erro de rede: ${res.statusText}`);
                }
                return res.json();
            })
            .then(data => {
                submitBtn.disabled = false;
                if (data.success) {
                    // Código válido: redireciona para o perfil
                    window.location.href = 'Perfil.php';
                } else {
                    errorEl.textContent = data.message || 'Código inválido.';
                    errorEl.style.display = 'block';
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                errorEl.textContent = 'Erro de comunicação. Tente novamente.';
                errorEl.style.display = 'block';
                console.error('2FA Fetch Error:', err);
            });
        });
    }

    // Se o modal já veio ativo via PHP, garante que ele seja aberto
    if (modal && modal.classList.contains('active')) {
        openModal();
    }

    // --- LÓGICA ADICIONAL (Ex: link para cadastro) ---
    const cadastreSeSpan = document.querySelector('.cadastre-se span');
    if (cadastreSeSpan) {
        cadastreSeSpan.addEventListener('click', function() {
            window.location.href = 'cadastro.php';
        });
    }
});
