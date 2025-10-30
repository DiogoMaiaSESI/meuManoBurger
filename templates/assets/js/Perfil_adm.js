document.addEventListener('DOMContentLoaded', function() {

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
        link.addEventListener('click', function(event) {
            event.preventDefault()

            // Normaliza ids mobile ("m-btn-dados") para ids da sidebar ("btn-dados")
            let targetId = this.id || ''
            if (targetId.startsWith('m-')) {
                targetId = targetId.replace(/^m-/, '')
            }

            if (!targetId.startsWith('btn-') && !targetId.startsWith('m-btn-') && targetId !== '') {
                targetId = 'btn-' + targetId.replace(/^btn-/, '')
            }


            activateTab(targetId)
        })
    })

    // --- LÓGICA DO MENU SANDUÍCHE ---
    const sandwichMenu = document.querySelector('.sandwich-menu-btn');
    const sandwichOptions = document.querySelector('.options');
    const sandwichSombra = document.querySelector('.sombra');

    function toggleMenu() {
        if (sandwichOptions) sandwichOptions.classList.toggle('optionActive');
        if (sandwichSombra) sandwichSombra.classList.toggle('shadowActive');
    }

    if (sandwichMenu) {
        sandwichMenu.addEventListener('click', toggleMenu);
    }
    if (sandwichSombra) {
        sandwichSombra.addEventListener('click', toggleMenu);
    }


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
            window.location.href = '/meuManoBurger/logout.php';
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

    // --- LÓGICA PARA TROCA DE FOTO DE PERFIL ---
    const editPicBtn = document.getElementById('edit-pic-btn');
    const fileUploadInput = document.getElementById('file-upload-input');
    const profilePicPreview = document.getElementById('profile-pic-preview');
    const picActionButtons = document.getElementById('pic-action-buttons');
    const savePicBtn = document.getElementById('save-pic-btn');
    const cancelPicBtn = document.getElementById('cancel-pic-btn');
    if (profilePicPreview) {
        let originalPicSrc = profilePicPreview.src;
        if (editPicBtn) {
            editPicBtn.addEventListener('click', () => fileUploadInput.click());
        }
        if (fileUploadInput) {
            fileUploadInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePicPreview.src = e.target.result;
                        if(picActionButtons) picActionButtons.classList.add('visible');
                        if(editPicBtn) editPicBtn.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
        if (cancelPicBtn) {
            cancelPicBtn.addEventListener('click', () => {
                profilePicPreview.src = originalPicSrc;
                fileUploadInput.value = '';
                if(picActionButtons) picActionButtons.classList.remove('visible');
                if(editPicBtn) editPicBtn.style.display = 'flex';
            });
        }
        if (savePicBtn) {
            savePicBtn.addEventListener('click', () => {
                const file = fileUploadInput.files[0];
                if (!file) return;
                console.log("Simulando upload da imagem:", file.name);
                originalPicSrc = profilePicPreview.src;
                if(picActionButtons) picActionButtons.classList.remove('visible');
                if(editPicBtn) editPicBtn.style.display = 'flex';
            });
        }
    }

    // --- LÓGICA PARA MOSTRAR/OCULTAR SENHA ---
    const togglePasswordIcons = document.querySelectorAll('.password-toggle-icon');
    togglePasswordIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
            const isPassword = passwordInput.type === 'password';
            if (isPassword) {
                passwordInput.type = 'text';
                this.src = '/meuManoBurger/templates/assets/img/olho.png';
            } else {
                passwordInput.type = 'password';
                this.src = '/meuManoBurger/templates/assets/img/olhofechado.png';
            }
        });
    });

    // --- LÓGICA DOS FORMULÁRIOS DA PÁGINA ---
    const profileForm = document.getElementById('profile-form');
    if (profileForm) {
        profileForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const submitBtn = this.querySelector('.submit-btn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Salvo!';
            setTimeout(() => {
                submitBtn.textContent = originalText;
            }, 2000);
        });
    }

    const securityForm = document.getElementById('security-form');
    if (securityForm) {
        const novaSenhaInput = document.getElementById('nova-senha');
        const confirmarSenhaInput = document.getElementById('confirmar-senha');
        const savePasswordBtn = document.getElementById('btn-salvar-senha');
        const errorMessage = document.getElementById('password-error-message');
        function validatePasswords() {
            const senha1 = novaSenhaInput.value;
            const senha2 = confirmarSenhaInput.value;
            if (senha1 || senha2) {
                if (senha1 === senha2 && senha1.length > 0) {
                    errorMessage.textContent = '';
                    savePasswordBtn.disabled = false;
                } else {
                    errorMessage.textContent = 'As senhas não coincidem.';
                    savePasswordBtn.disabled = true;
                }
            } else {
                errorMessage.textContent = '';
                savePasswordBtn.disabled = true;
            }
        }
        if (novaSenhaInput) novaSenhaInput.addEventListener('keyup', validatePasswords);
        if (confirmarSenhaInput) confirmarSenhaInput.addEventListener('keyup', validatePasswords);
        if (savePasswordBtn) savePasswordBtn.disabled = true;
        securityForm.addEventListener('submit', function(event) {
            event.preventDefault();
            if (savePasswordBtn.disabled) return;
            const originalText = savePasswordBtn.textContent;
            savePasswordBtn.textContent = 'Senha Alterada!';
            novaSenhaInput.value = '';
            confirmarSenhaInput.value = '';
            savePasswordBtn.disabled = true;
            setTimeout(() => {
                savePasswordBtn.textContent = originalText;
            }, 2000);
        });
    }
});
