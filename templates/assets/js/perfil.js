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

    // --- LÓGICA PARA TROCA DE FOTO DE PERFIL (VISUAL) ---
    const editPicBtn = document.getElementById('edit-pic-btn');
    const profileForm = document.getElementById('profile-form');
    const profilePicPreview = document.getElementById('profile-pic-preview');

    if (editPicBtn && profileForm) {
        const formFileInput = profileForm.querySelector('input[name="imagem_cliente"]');
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

    // --- LÓGICA DO MODAL DE PAGAMENTO E EXCLUSÃO  ---
    // Esta seção é importante e foi mantida do seu código original.
    const paymentModal = document.getElementById('modal-add-card');
    const cardForm = document.getElementById('card-form');
    const paymentListContainer = document.getElementById('payment-methods-list');
    const brandButtons = document.querySelectorAll('.brand-btn');
    const selectedCardInput = document.getElementById('card-brand-selected');
    const typeButtons = document.querySelectorAll('.type-btn');
    const selectedTypeInput = document.getElementById('card-type-selected');
    const modalTitle = document.getElementById('modal-title');
    const modalSubmitBtn = document.getElementById('modal-submit-btn');
    const deleteModal = document.getElementById('modal-confirm-delete');
    let isEditing = false;
    let cardBeingEdited = null;
    let cardToDelete = null;

    function openPaymentModalForAdd() {
        isEditing = false;
        if (cardForm) cardForm.reset();
        if (brandButtons) brandButtons.forEach(btn => btn.classList.remove('selected'));
        if (typeButtons) typeButtons.forEach(btn => btn.classList.remove('selected'));
        if (modalTitle) modalTitle.textContent = 'Adicionar novo cartão';
        if (modalSubmitBtn) modalSubmitBtn.textContent = 'Salvar Cartão';
        if (paymentModal) paymentModal.classList.add('active');
    }

    function openPaymentModalForEdit(cardElement) {
        isEditing = true;
        cardBeingEdited = cardElement;
        document.getElementById('card-nickname').value = cardElement.dataset.nickname;
        document.getElementById('card-number').value = cardElement.dataset.number;
        document.getElementById('card-expiry').value = cardElement.dataset.expiry;
        document.getElementById('card-cvv').value = cardElement.dataset.cvv;
        document.getElementById('card-holder-name').value = cardElement.dataset.holder;
        const brand = cardElement.dataset.brand;
        if (selectedCardInput) selectedCardInput.value = brand;
        if (brandButtons) brandButtons.forEach(btn => { btn.classList.toggle('selected', btn.dataset.brand === brand); });
        const type = cardElement.dataset.type;
        if (selectedTypeInput) selectedTypeInput.value = type;
        if (typeButtons) typeButtons.forEach(btn => { btn.classList.toggle('selected', btn.dataset.type === type); });
        if (modalTitle) modalTitle.textContent = 'Editar Cartão';
        if (modalSubmitBtn) modalSubmitBtn.textContent = 'Salvar Alterações';
        if (paymentModal) paymentModal.classList.add('active');
    }

    function closePaymentModal() {
        if (paymentModal) paymentModal.classList.remove('active');
    }

    function openDeleteModal(cardElement) {
        cardToDelete = cardElement;
        if (deleteModal) deleteModal.classList.add('active');
    }

    function closeDeleteModal() {
        cardToDelete = null;
        if (deleteModal) deleteModal.classList.remove('active');
    }

    document.addEventListener('click', function (event) {
        const addBtn = event.target.closest('.add-payment-btn');
        const editBtn = event.target.closest('.edit-card-btn');
        const deleteBtn = event.target.closest('.delete-card-btn');
        const closePaymentBtn = event.target.closest('.close-modal-btn');

        if (addBtn) openPaymentModalForAdd();
        else if (editBtn) openPaymentModalForEdit(editBtn.closest('.payment-method-item'));
        else if (deleteBtn) openDeleteModal(deleteBtn.closest('.payment-method-item'));
        else if (closePaymentBtn) closePaymentModal();
    });

    if (paymentModal) paymentModal.addEventListener('click', (event) => { if (event.target === paymentModal) closePaymentModal(); });

    if (brandButtons) brandButtons.forEach(button => {
        button.addEventListener('click', () => {
            brandButtons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
            if (selectedCardInput) selectedCardInput.value = button.dataset.brand;
        });
    });

    if (typeButtons) typeButtons.forEach(button => {
        button.addEventListener('click', () => {
            typeButtons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
            if (selectedTypeInput) selectedTypeInput.value = button.dataset.type;
        });
    });

    if (cardForm) {
        cardForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const cardNickname = document.getElementById('card-nickname').value;
            const cardNumber = document.getElementById('card-number').value;
            const cardExpiry = document.getElementById('card-expiry').value;
            const cardCvv = document.getElementById('card-cvv').value;
            const cardHolder = document.getElementById('card-holder-name').value;
            const selectedBrand = selectedCardInput.value;
            const selectedType = selectedTypeInput.value; // Adicionado

            if (!cardNickname || !selectedBrand || !selectedType || !cardNumber || !cardExpiry || !cardCvv || !cardHolder) {
                alert('Por favor, preencha todos os campos do cartão.');
                return;
            }

            const expiryParts = cardExpiry.split('/');
            if (expiryParts.length !== 2) {
                alert('Formato da data de validade inválido. Use MM/AA.');
                return;
            }

            const expiryMonth = parseInt(expiryParts[0], 10);
            const expiryYear = parseInt('20' + expiryParts[1], 10);

            if (isNaN(expiryMonth) || isNaN(expiryYear) || expiryMonth < 1 || expiryMonth > 12) {
                alert('Mês de validade inválido. Use um valor entre 01 e 12.');
                return;
            }

            const currentDate = new Date();
            const currentMonth = currentDate.getMonth() + 1;
            const currentYear = currentDate.getFullYear();

            if (expiryYear < currentYear || (expiryYear === currentYear && expiryMonth < currentMonth)) {
                alert('A data de validade do cartão já expirou.');
                return;
            }

            const capitalizedBrand = selectedBrand.charAt(0).toUpperCase() + selectedBrand.slice(1);
            const brandIconSrc = `/meuManoBurger/templates/assets/img/${capitalizedBrand}.webp`;

            if (isEditing && cardBeingEdited) {
                cardBeingEdited.dataset.nickname = cardNickname;
                cardBeingEdited.dataset.number = cardNumber;
                cardBeingEdited.dataset.expiry = cardExpiry;
                cardBeingEdited.dataset.cvv = cardCvv;
                cardBeingEdited.dataset.holder = cardHolder;
                cardBeingEdited.dataset.brand = selectedBrand;
                cardBeingEdited.dataset.type = selectedType; // Adicionado
                cardBeingEdited.querySelector('.card-info span').textContent = `${cardNickname} (${capitalizedBrand})`;
                cardBeingEdited.querySelector('.payment-icon').src = brandIconSrc;
                cardBeingEdited.querySelector('.payment-icon').alt = capitalizedBrand;
            } else {
                const newCardElement = document.createElement('div');
                newCardElement.className = 'payment-method-item';
                newCardElement.dataset.nickname = cardNickname;
                newCardElement.dataset.number = cardNumber;
                newCardElement.dataset.expiry = cardExpiry;
                newCardElement.dataset.cvv = cardCvv;
                newCardElement.dataset.holder = cardHolder;
                newCardElement.dataset.brand = selectedBrand;
                newCardElement.dataset.type = selectedType; // Adicionado
                newCardElement.innerHTML = `
                    <div class="card-info">
                        <figure class="payment-icon-figure"><img src="${brandIconSrc}" alt="${capitalizedBrand}" class="payment-icon"></figure>
                        <span>${cardNickname} (${capitalizedBrand})</span>
                    </div>
                    <div class="card-actions">
                        <button type="button" class="edit-card-btn">
                            <img src="/meuManoBurger/templates/assets/img/Edicao.png" alt="Editar Cartão" class="icon-editar-card">
                        </button>
                        <button type="button" class="delete-card-btn">
                            <img src="/meuManoBurger/templates/assets/img/Lixeira.png" alt="Excluir Cartão" class="icon-delete-card">
                        </button>
                    </div>
                `;
                if (paymentListContainer) paymentListContainer.appendChild(newCardElement);
            }
            cardForm.reset();
            if (brandButtons) brandButtons.forEach(btn => btn.classList.remove('selected'));
            if (typeButtons) typeButtons.forEach(btn => btn.classList.remove('selected')); // Adicionado
            closePaymentModal();
        });
    }

    if (deleteModal) {
        const btnDeleteNao = document.getElementById('btn-delete-nao');
        const btnDeleteSim = document.getElementById('btn-delete-sim');
        if (btnDeleteNao) btnDeleteNao.addEventListener('click', closeDeleteModal);
        if (btnDeleteSim) btnDeleteSim.addEventListener('click', () => {
            if (cardToDelete) {
                cardToDelete.remove();
            }
            closeDeleteModal();
        });
        deleteModal.addEventListener('click', (event) => { if (event.target === deleteModal) closeDeleteModal(); });
    }

    // --- LÓGICA DAS MÁSCARAS DO FORMULÁRIO DO CARTÃO ---
    const cardNumberInput = document.getElementById('card-number');
    const cardExpiryInput = document.getElementById('card-expiry');
    const cardCvvInput = document.getElementById('card-cvv');
    if (cardNumberInput) cardNumberInput.addEventListener('input', (e) => { e.target.value = e.target.value.replace(/\D/g, '').substring(0, 16).replace(/(\d{4})(?=\d)/g, '$1 '); });
    if (cardExpiryInput) cardExpiryInput.addEventListener('input', (e) => { e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4).replace(/(\d{2})(?=\d)/, '$1/'); });
    if (cardCvvInput) cardCvvInput.addEventListener('input', (e) => { e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4); });

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
                const resp = await fetch('/meuManoBurger/View/api.php?action=generate-2fa', {
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
                const response = await fetch('/meuManoBurger/View/api.php?action=verify-2fa', {
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
                    // ANTES (com alert):
                    // alert(data.message);
                    // window.location.reload();

                    // DEPOIS (com notificação toast):
                    // Define a mensagem de sucesso na sessão através de uma chamada rápida à API
                    fetch('/meuManoBurger/View/api.php?action=set-flash-message', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: new URLSearchParams({
                            type: 'success',
                            message: 'Autenticação de 2 Fatores ativada com sucesso!'
                        })
                    }).then(() => {
                        // Apenas recarrega a página. O PHP cuidará de mostrar a notificação.
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
            window.location.href = 'cardapio.php'
        }else if(index===1){
            window.location.href = 'pedidosUSER.php'
        }else if(index===2){
            window.location.href = 'paginaPrincipalUser.php#feedback'
        }else if(index===3){
            window.location.href = 'carrinho.php'
        }
    })
})