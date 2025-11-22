document.addEventListener('DOMContentLoaded', function () {

    // --- LÓGICA PARA TROCA DE ABAS (SINCRONIZADA) ---
    const navLinks = document.querySelectorAll('.nav-link');
    const contentTabs = document.querySelectorAll('.content-tab');

    function activateTab(targetId) {
        if (!targetId) return;
        navLinks.forEach(nav => nav.classList.remove('active'));
        contentTabs.forEach(tab => tab.classList.remove('active'));

        const targetName = targetId.substring(targetId.indexOf('-') + 1);
        const targetContentId = 'content-' + targetName;

        const sidebarLink = document.getElementById('btn-' + targetName);
        const mobileLink = document.getElementById('m-btn-' + targetName);
        if (sidebarLink) sidebarLink.classList.add('active');
        if (mobileLink) mobileLink.classList.add('active');

        const targetTab = document.getElementById(targetContentId);
        if (targetTab) {
            targetTab.classList.add('active');
        }
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            //event.preventDefault();
            let targetId = this.id || '';
            // Normaliza o ID do menu mobile para corresponder ao da sidebar
            if (targetId.startsWith('m-')) {
                targetId = 'btn-' + targetId.substring(targetId.indexOf('-') + 1);
            }
            activateTab(targetId);
        });
    });

    // --- LÓGICA DO MENU SANDUÍCHE ---
    const sandwichMenu = document.querySelector('.sandwich-menu-btn');
    const sandwichOptions = document.querySelector('.options');
    const sandwichSombra = document.querySelector('.sombra');

    function toggleMenu() {
        if (sandwichOptions) sandwichOptions.classList.toggle('optionActive');
        if (sandwichSombra) sandwichSombra.classList.toggle('shadowActive');
    }

    if (sandwichMenu) sandwichMenu.addEventListener('click', toggleMenu);
    if (sandwichSombra) sandwichSombra.addEventListener('click', toggleMenu);

    // --- LÓGICA DO MODAL DE LOGOUT ---
    const logoutModal = document.getElementById('modal-confirm-logout');
    const openLogoutModalBtn = document.getElementById('btn-sair');
    const mobileOpenLogoutModalBtn = document.getElementById('m-btn-sair');
    const closeLogoutModalBtn = document.getElementById('btn-logout-nao');
    const confirmLogoutBtn = document.getElementById('btn-logout-sim');

    function openLogoutModal(event) {
        event.preventDefault();
        if (logoutModal) logoutModal.classList.add('active');
    }

    if (openLogoutModalBtn) openLogoutModalBtn.addEventListener('click', openLogoutModal);
    if (mobileOpenLogoutModalBtn) mobileOpenLogoutModalBtn.addEventListener('click', openLogoutModal);

    if (closeLogoutModalBtn) {
        closeLogoutModalBtn.addEventListener('click', () => {
            if (logoutModal) logoutModal.classList.remove('active');
            activateTab('btn-dados');
        });
    }
    if (confirmLogoutBtn) {
        confirmLogoutBtn.addEventListener('click', () => {
            window.location.href = 'perfil.php?action=logout';
        });
    }
    if (logoutModal) {
        logoutModal.addEventListener('click', (event) => {
            if (event.target === logoutModal) {
                logoutModal.classList.remove('active');
                activateTab('btn-dados');
            }
        });
    }

    const editPicBtn = document.getElementById('edit-pic-btn');
    const profileForm = document.getElementById('profile-form');
    const profilePicPreview = document.getElementById('profile-pic-preview');

    if (editPicBtn && profileForm) {
        const formFileInput = profileForm.querySelector('input[name="imagem_adm"]');
        if (formFileInput) {
            editPicBtn.addEventListener('click', () => formFileInput.click());

            formFileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        if (profilePicPreview) profilePicPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    }

    // --- LÓGICA PARA MOSTRAR/OCULTAR SENHA ---
    const togglePasswordIcons = document.querySelectorAll('.password-toggle-icon');
    togglePasswordIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            const passwordInput = this.previousElementSibling;
            if (passwordInput && passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.src = '/meuManoBurger/templates/assets/img/olho.png';
            } else if (passwordInput) {
                passwordInput.type = 'password';
                this.src = '/meuManoBurger/templates/assets/img/olhofechado.png';
            }
        });
    });
    const open2FAModalBtn = document.querySelector('.add-2fa-link');
    const modal2FA = document.getElementById('modal-2fa');
    const close2FAModalBtn = document.getElementById('close-2fa-modal-btn');
    const qrCodeContainer = document.getElementById('qr-code-container');
    const secretInput = document.getElementById('2fa-secret-input');
    const verifyForm = document.getElementById('2fa-verify-form');
    const errorCodeMessage = document.getElementById('2fa-error-message');

    if (open2FAModalBtn) {
        open2FAModalBtn.addEventListener('click', async function (event) {
            event.preventDefault();
            qrCodeContainer.innerHTML = '<p>Gerando QR Code...</p>';
            if (errorCodeMessage) errorCodeMessage.textContent = '';
            const codeInput = document.getElementById('2fa-code');
            if (codeInput) codeInput.value = '';
            if (modal2FA) modal2FA.classList.add('active');

            try {
                const resp = await fetch('/meuManoBurger/View/api_adm.php?action=generate-2fa', {
                    method: 'GET',
                    credentials: 'same-origin'
                });

                const text = await resp.text();
                let data;
                try { data = JSON.parse(text); }
                catch (err) { throw new Error('Resposta inválida do servidor: ' + text.substring(0, 300)); }

                if (!resp.ok) throw new Error('HTTP ' + resp.status + ' — ' + (data.message || 'Erro no servidor'));

                if (data.success) {
                    const qr = data.qrCodeUrl || '';
                    if (/^\s*(data:|https?:\/\/)/i.test(qr)) {
                        qrCodeContainer.innerHTML = `<img src="${qr}" alt="QR Code para 2FA">`;
                    }
                    else if (/^\s*</.test(qr)) {
                        qrCodeContainer.innerHTML = qr;
                    }
                    else {
                        qrCodeContainer.innerHTML = `<p>${qr}</p>`;
                    }
                    if (typeof secretInput !== 'undefined' && secretInput) {
                        secretInput.value = data.secret || '';
                    }
                } else {
                    qrCodeContainer.innerHTML = `<p style="color: red;">${data.message || 'Erro ao gerar QR Code.'}</p>`;
                }
            } catch (error) {
                console.error('generate-2fa error:', error);
                qrCodeContainer.innerHTML = '<p style="color: red;">Erro de comunicação com o servidor.</p>';
            }
        });
    }
    // --- LÓGICA PARA DESATIVAÇÃO DO 2FA ---
    const openDisableModalBtn = document.getElementById('btn-open-disable-2fa');
    const disable2FAModal = document.getElementById('modal-disable-2fa');
    const closeDisableModalBtn = document.getElementById('close-disable-2fa-modal-btn');
    const disable2FAForm = document.getElementById('disable-2fa-form');
    const disableErrorMsg = document.getElementById('disable-2fa-error-message');

    if (openDisableModalBtn) {
        openDisableModalBtn.addEventListener('click', () => {
            if (disable2FAModal) disable2FAModal.classList.add('active');
        });
    }

    function closeDisableModal() {
        if (disable2FAModal) disable2FAModal.classList.remove('active');
        if (disableErrorMsg) disableErrorMsg.textContent = '';
        if (disable2FAForm) disable2FAForm.reset();
    }

    if (closeDisableModalBtn) {
        closeDisableModalBtn.addEventListener('click', closeDisableModal);
    }
    if (disable2FAModal) {
        disable2FAModal.addEventListener('click', (e) => {
            if (e.target === disable2FAModal) closeDisableModal();
        });
    }

    if (disable2FAForm) {
        disable2FAForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const passwordInput = document.getElementById('disable-2fa-password');
            const password = passwordInput.value;

            if (!password) {
                disableErrorMsg.textContent = 'Por favor, digite sua senha.';
                return;
            }

            const formData = new FormData();
            formData.append('password', password);

            try {
                const response = await fetch('/meuManoBurger/View/api.php?action=disable-2fa', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (data.success) {
                    window.location.reload();
                } else {
                    disableErrorMsg.textContent = data.message || 'Ocorreu um erro.';
                }
            } catch (error) {
                disableErrorMsg.textContent = 'Erro de comunicação com o servidor.';
            }
        });
    }

    function close2FAModal() {
        if (modal2FA) modal2FA.classList.remove('active');
    }

    if (close2FAModalBtn) {
        close2FAModalBtn.addEventListener('click', close2FAModal);
    }
    if (modal2FA) {
        modal2FA.addEventListener('click', (event) => {
            if (event.target === modal2FA) {
                close2FAModal();
            }
        });
    }

    if (verifyForm) {
        verifyForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            const code = document.getElementById('2fa-code').value;
            const secret = secretInput.value;

            const formData = new FormData();
            formData.append('secret', secret);
            formData.append('code', code);

            try {
                const response = await fetch('/meuManoBurger/View/api_adm.php?action=verify-2fa', {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                });

                const text = await response.text();
                let data;
                try { data = JSON.parse(text); }
                catch (err) { throw new Error('Resposta inválida do servidor: ' + text.substring(0, 300)); }

                if (!response.ok) throw new Error('HTTP ' + response.status + ' — ' + (data.message || 'Erro no servidor'));

                if (data.success) {
                    fetch('/meuManoBurger/View/api.php?action=set-flash-message', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: new URLSearchParams({
                            type: 'success',
                            message: 'Autenticação de 2 Fatores ativada com sucesso!'
                        })
                    }).then(() => {
                        window.location.reload();
                    });

                } else {
                    errorCodeMessage.textContent = data.message || 'Erro desconhecido.';
                }
            } catch (error) {
                console.error('verify-2fa error:', error);
                errorCodeMessage.textContent = 'Erro de comunicação com o servidor.';
            }
        });
    }

});



const option = document.querySelectorAll('.option')
option.forEach((op, index)=>{
    op.addEventListener('click',()=>{
        if(index===0){
            window.location.href = 'cardapio_adm.php'
        }else if(index===1){
            window.location.href = 'pedidosADM.php'
        }else if(index===2){
            window.location.href = 'empresa.php#feedback'
        }
    })
})