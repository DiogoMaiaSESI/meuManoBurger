document.addEventListener('DOMContentLoaded', function() {

    const navLinks = document.querySelectorAll('.nav-link');
    const contentTabs = document.querySelectorAll('.content-tab');
    navLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const clickedId = this.id;
            const targetName = clickedId.substring(4);
            const targetContentId = 'content-' + targetName;
            navLinks.forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');
            contentTabs.forEach(tab => tab.classList.remove('active'));
            const targetTab = document.getElementById(targetContentId);
            if (targetTab) {
                targetTab.classList.add('active');
            }
        });
    });

    const logoutModal = document.getElementById('modal-confirm-logout');
    const openLogoutModalBtn = document.getElementById('btn-sair');
    const closeLogoutModalBtn = document.getElementById('btn-logout-nao');
    const confirmLogoutBtn = document.getElementById('btn-logout-sim');
    if (openLogoutModalBtn) {
        openLogoutModalBtn.addEventListener('click', function(event) {
            event.preventDefault();
            if (logoutModal) {
                logoutModal.classList.add('active');
            }
        });
    }
    if (closeLogoutModalBtn) {
        closeLogoutModalBtn.addEventListener('click', () => {
            if (logoutModal) {
                logoutModal.classList.remove('active');
            }
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
            }
        });
    }

    const editPicBtn = document.getElementById('edit-pic-btn');
    const fileUploadInput = document.getElementById('file-upload-input');
    const profilePicPreview = document.getElementById('profile-pic-preview');
    const picActionButtons = document.getElementById('pic-action-buttons');
    const savePicBtn = document.getElementById('save-pic-btn');
    const cancelPicBtn = document.getElementById('cancel-pic-btn');
    let originalPicSrc = profilePicPreview.src;
    if (editPicBtn) {
        editPicBtn.addEventListener('click', () => {
            fileUploadInput.click();
        });
    }
    if (fileUploadInput) {
        fileUploadInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePicPreview.src = e.target.result;
                    picActionButtons.classList.add('visible');
                    editPicBtn.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });
    }
    if (cancelPicBtn) {
        cancelPicBtn.addEventListener('click', () => {
            profilePicPreview.src = originalPicSrc;
            fileUploadInput.value = '';
            picActionButtons.classList.remove('visible');
            editPicBtn.style.display = 'flex';
        });
    }
    if (savePicBtn) {
        savePicBtn.addEventListener('click', () => {
            const file = fileUploadInput.files[0];
            if (!file) return;
            console.log("Simulando upload da imagem:", file.name);
            originalPicSrc = profilePicPreview.src;
            picActionButtons.classList.remove('visible');
            editPicBtn.style.display = 'flex';
        });
    }

    const modal = document.getElementById('modal-add-card');
    const cardForm = document.getElementById('card-form');
    const paymentListContainer = document.getElementById('payment-methods-list');
    const brandButtons = document.querySelectorAll('.brand-btn');
    const selectedCardInput = document.getElementById('card-brand-selected');
    const modalTitle = document.getElementById('modal-title');
    const modalSubmitBtn = document.getElementById('modal-submit-btn');
    let isEditing = false;
    let cardBeingEdited = null;
    function openModalForAdd() {
        isEditing = false;
        cardForm.reset();
        brandButtons.forEach(btn => btn.classList.remove('selected'));
        modalTitle.textContent = 'Adicionar novo cartão';
        modalSubmitBtn.textContent = 'Salvar Cartão';
        if (modal) modal.classList.add('active');
    }
    function openModalForEdit(cardElement) {
        isEditing = true;
        cardBeingEdited = cardElement;
        document.getElementById('card-nickname').value = cardElement.dataset.nickname;
        document.getElementById('card-number').value = cardElement.dataset.number;
        document.getElementById('card-expiry').value = cardElement.dataset.expiry;
        document.getElementById('card-cvv').value = cardElement.dataset.cvv;
        document.getElementById('card-holder-name').value = cardElement.dataset.holder;
        const brand = cardElement.dataset.brand;
        selectedCardInput.value = brand;
        brandButtons.forEach(btn => {
            if (btn.dataset.brand === brand) {
                btn.classList.add('selected');
            } else {
                btn.classList.remove('selected');
            }
        });
        modalTitle.textContent = 'Editar Cartão';
        modalSubmitBtn.textContent = 'Salvar Alterações';
        if (modal) modal.classList.add('active');
    }
    function closeModal() {
        if (modal) modal.classList.remove('active');
    }
    document.addEventListener('click', function(event) {
        const addBtn = event.target.closest('.add-payment-btn');
        const editBtn = event.target.closest('.edit-card-btn');
        const closeBtn = event.target.closest('.close-modal-btn');
        if (addBtn) openModalForAdd();
        else if (editBtn) {
            const cardElement = editBtn.closest('.payment-method-item');
            openModalForEdit(cardElement);
        } else if (closeBtn) closeModal();
    });
    if (modal) modal.addEventListener('click', (event) => { if (event.target === modal) closeModal(); });
    brandButtons.forEach(button => {
        button.addEventListener('click', () => {
            brandButtons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
            selectedCardInput.value = button.dataset.brand;
        });
    });
    if (cardForm) {
        cardForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const cardNickname = document.getElementById('card-nickname').value;
            const cardNumber = document.getElementById('card-number').value;
            const cardExpiry = document.getElementById('card-expiry').value;
            const cardCvv = document.getElementById('card-cvv').value;
            const cardHolder = document.getElementById('card-holder-name').value;
            const selectedBrand = selectedCardInput.value;
            if (!cardNickname || !selectedBrand || !cardNumber || !cardExpiry || !cardCvv || !cardHolder) {
                alert('Por favor, preencha todos os campos do cartão.');
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
                newCardElement.innerHTML = `
                    <div class="card-info">
                        <figure class="payment-icon-figure"><img src="${brandIconSrc}" alt="${capitalizedBrand}" class="payment-icon"></figure>
                        <span>${cardNickname} (${capitalizedBrand})</span>
                    </div>
                    <button type="button" class="edit-card-btn"><img src="/meuManoBurger/templates/assets/img/Edicao.png" alt="Editar Cartão" class="icon-editar-card"></button>
                `;
                if (paymentListContainer) paymentListContainer.appendChild(newCardElement);
            }
            cardForm.reset();
            brandButtons.forEach(btn => btn.classList.remove('selected'));
            closeModal();
        });
    }

    const cardNumberInput = document.getElementById('card-number');
    const cardExpiryInput = document.getElementById('card-expiry');
    const cardCvvInput = document.getElementById('card-cvv');
    if (cardNumberInput) cardNumberInput.addEventListener('input', (e) => { e.target.value = e.target.value.replace(/\D/g, '').substring(0, 16).replace(/(\d{4})(?=\d)/g, '$1 '); });
    if (cardExpiryInput) cardExpiryInput.addEventListener('input', (e) => { e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4).replace(/(\d{2})(?=\d)/, '$1/'); });
    if (cardCvvInput) cardCvvInput.addEventListener('input', (e) => { e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4); });

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
