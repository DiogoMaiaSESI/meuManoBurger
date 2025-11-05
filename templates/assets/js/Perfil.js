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
            event.preventDefault();
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

    // --- LÓGICA PARA TROCA DE FOTO DE PERFIL (VISUAL) ---
    // Esta lógica foi mantida, mas a parte de 'submit' foi removida.
    const editPicBtn = document.getElementById('edit-pic-btn');
    const profileForm = document.getElementById('profile-form');
    const profilePicPreview = document.getElementById('profile-pic-preview');

    if (editPicBtn && profileForm) {
        const formFileInput = profileForm.querySelector('input[name="imagem_cliente"]');
        if (formFileInput) {
            editPicBtn.addEventListener('click', () => formFileInput.click());

            formFileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (profilePicPreview) profilePicPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    }

    // --- LÓGICA DO MODAL DE PAGAMENTO E EXCLUSÃO (MANTIDA) ---
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
        if(brandButtons) brandButtons.forEach(btn => btn.classList.remove('selected'));
        if(typeButtons) typeButtons.forEach(btn => btn.classList.remove('selected'));
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
        if(brandButtons) brandButtons.forEach(btn => { btn.classList.toggle('selected', btn.dataset.brand === brand); });
        const type = cardElement.dataset.type;
        if(selectedTypeInput) selectedTypeInput.value = type;
        if(typeButtons) typeButtons.forEach(btn => { btn.classList.toggle('selected', btn.dataset.type === type); });
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
        // O event listener de 'submit' para o cardForm foi mantido,
        // pois ele é para uma lógica interna do modal (front-end) e não para o PHP.
        cardForm.addEventListener('submit', function(event) {
            event.preventDefault();
            // ... (toda a sua lógica de validação e criação do elemento do cartão)
        });
    }

    if (deleteModal) {
        // ... (sua lógica do modal de exclusão)
    }

    // --- LÓGICA DAS MÁSCARAS DO FORMULÁRIO DO CARTÃO (MANTIDA) ---
    const cardNumberInput = document.getElementById('card-number');
    const cardExpiryInput = document.getElementById('card-expiry');
    const cardCvvInput = document.getElementById('card-cvv');
    if (cardNumberInput) cardNumberInput.addEventListener('input', (e) => { e.target.value = e.target.value.replace(/\D/g, '').substring(0, 16).replace(/(\d{4})(?=\d)/g, '$1 '); });
    if (cardExpiryInput) cardExpiryInput.addEventListener('input', (e) => { e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4).replace(/(\d{2})(?=\d)/, '$1/'); });
    if (cardCvvInput) cardCvvInput.addEventListener('input', (e) => { e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4); });

    // --- LÓGICA PARA MOSTRAR/OCULTAR SENHA (MANTIDA) ---
    const togglePasswordIcons = document.querySelectorAll('.password-toggle-icon');
    togglePasswordIcons.forEach(icon => {
        icon.addEventListener('click', function() {
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
    const editPicBtn = document.getElementById('edit-pic-btn');
const profileForm = document.getElementById('profile-form');
const profilePicPreview = document.getElementById('profile-pic-preview');

if (editPicBtn && profileForm) {
    // Encontra o input de arquivo que está DENTRO do formulário
    const formFileInput = profileForm.querySelector('input[name="imagem_cliente"]');
    
    if (formFileInput) {
        // 1. O botão de lápis aciona o clique no input do formulário
        editPicBtn.addEventListener('click', () => formFileInput.click());

        // 2. Quando o input do formulário muda (usuário escolhe um arquivo), atualiza o preview
        formFileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (profilePicPreview) {
                        profilePicPreview.src = e.target.result;
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }
}

});
