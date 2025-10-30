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
        // Corrigido para usar as classes certas do seu HTML
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
    const mobileOpenLogoutModalBtn = document.getElementById('m-btn-sair'); // Botão mobile
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

    // --- LÓGICA DO MODAL DE PAGAMENTO E EXCLUSÃO ---
    const paymentModal = document.getElementById('modal-add-card');
    const cardForm = document.getElementById('card-form');
    const paymentListContainer = document.getElementById('payment-methods-list');
    const brandButtons = document.querySelectorAll('.brand-btn');
    const selectedCardInput = document.getElementById('card-brand-selected');
    const typeButtons = document.querySelectorAll('.type-btn'); // Adicionado
    const selectedTypeInput = document.getElementById('card-type-selected'); // Adicionado
    const modalTitle = document.getElementById('modal-title');
    const modalSubmitBtn = document.getElementById('modal-submit-btn');
    const deleteModal = document.getElementById('modal-confirm-delete');
    let isEditing = false;
    let cardBeingEdited = null;
    let cardToDelete = null;

    function openPaymentModalForAdd() {
        isEditing = false;
        if (cardForm) cardForm.reset();
        if(brandButtons) brandButtons.forEach(btn => btn.classList.remove('selected'));
        if(typeButtons) typeButtons.forEach(btn => btn.classList.remove('selected')); // Adicionado
        if(modalTitle) modalTitle.textContent = 'Adicionar novo cartão';
        if(modalSubmitBtn) modalSubmitBtn.textContent = 'Salvar Cartão';
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
        if(selectedCardInput) selectedCardInput.value = brand;
        if(brandButtons) brandButtons.forEach(btn => {
            btn.classList.toggle('selected', btn.dataset.brand === brand);
        });
        // Lógica para preencher o tipo de cartão ao editar (se você salvar esse dado)
        const type = cardElement.dataset.type;
        if(selectedTypeInput) selectedTypeInput.value = type;
        if(typeButtons) typeButtons.forEach(btn => {
            btn.classList.toggle('selected', btn.dataset.type === type);
        });
        if(modalTitle) modalTitle.textContent = 'Editar Cartão';
        if(modalSubmitBtn) modalSubmitBtn.textContent = 'Salvar Alterações';
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

    document.addEventListener('click', function(event) {
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
    
    if(brandButtons) brandButtons.forEach(button => {
        button.addEventListener('click', () => {
            brandButtons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
            if(selectedCardInput) selectedCardInput.value = button.dataset.brand;
        });
    });

    if(typeButtons) typeButtons.forEach(button => {
        button.addEventListener('click', () => {
            typeButtons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
            if(selectedTypeInput) selectedTypeInput.value = button.dataset.type;
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
            if(brandButtons) brandButtons.forEach(btn => btn.classList.remove('selected'));
            if(typeButtons) typeButtons.forEach(btn => btn.classList.remove('selected')); // Adicionado
            closePaymentModal();
        });
    }

    if (deleteModal) {
        const btnDeleteNao = document.getElementById('btn-delete-nao');
        const btnDeleteSim = document.getElementById('btn-delete-sim');
        if(btnDeleteNao) btnDeleteNao.addEventListener('click', closeDeleteModal);
        if(btnDeleteSim) btnDeleteSim.addEventListener('click', () => {
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
