document.addEventListener('DOMContentLoaded', function () {

    // ===================================================================
    // 1. SELETORES DE ELEMENTOS (com verificações)
    // ===================================================================

    // --- Ícones e Navegação ---
    const menuIcon = document.querySelector('.menu');
    const backButton = document.querySelector('.back');
    const lapisIcon = document.querySelector('.lapis');
    const lixeiraIcon = document.querySelector('.lixeira');
    const optionsMenu = document.querySelector('.options');
    const sombraMenu = document.querySelector('.sombra');

    // --- Formulário e Modal de Edição ---
    const editModal = document.getElementById('edit-product-form');
    const sombraForm = document.querySelector('.sombraForm');
    const previewImage = editModal ? editModal.querySelector('#edit-preview-img') : null;
    const fotoInputEdit = editModal ? editModal.querySelector('#edit-foto-input') : null;
    const btnCancelarEdit = editModal ? editModal.querySelector('.cancelar') : null;

    // --- Formulário e Modal de Exclusão ---
    const deleteForm = document.getElementById('delete-product-form');
    const deleteOverlay = document.querySelector('.deleteForm');
    const deleteModal = deleteForm ? deleteForm.querySelector('.apagar') : null;
    const btnCancelarDelete = deleteForm ? deleteForm.querySelector('.cancelar2') : null;

    // ===================================================================
    // 2. FUNÇÕES DE TOGGLE (para mostrar/esconder)
    // ===================================================================

    const toggleSideMenu = () => {
        if (optionsMenu && sombraMenu) {
            optionsMenu.classList.toggle('optionActive');
            sombraMenu.classList.toggle('shadowActive');
        }
    };

    const toggleEditModal = () => {
        if (editModal && sombraForm) {
            editModal.classList.toggle('formActive');
            sombraForm.classList.toggle('shadowFormActive');
        }
    };

    const toggleDeleteModal = () => {
        if (deleteOverlay && deleteModal) {
            deleteOverlay.classList.toggle('deleteFormActive');
            deleteModal.classList.toggle('apagarActive');
            sombraForm.classList.toggle('shadowFormActive');
        }
    };

    // ===================================================================
    // 3. EVENT LISTENERS (Ouvintes de Ações)
    // ===================================================================

    // --- Navegação e Menu ---
    if (menuIcon) menuIcon.addEventListener('click', toggleSideMenu);
    if (sombraMenu) sombraMenu.addEventListener('click', toggleSideMenu);
    if (backButton) backButton.addEventListener('click', () => window.history.back());

    // --- Abrir Modal de Edição ---
    if (lapisIcon) {
        lapisIcon.addEventListener('click', () => {
            if (!editModal) return; // Segurança extra
            // Preenche o formulário
            document.getElementById('edit-nome').value = document.querySelector('.rightDiv .title h2').textContent.trim();
            document.getElementById('edit-descricao').value = document.querySelector('.rightDiv p').textContent.trim();
            const priceText = document.querySelector('.rightDiv .price').textContent.replace('R$', '').replace(/\./g, '').replace(',', '.').trim();
            document.getElementById('edit-preco').value = parseFloat(priceText);
            document.getElementById('edit-quantidade').value = parseInt(document.querySelector('.secondDiv div:nth-child(2) .subtitle2').textContent.trim());
            document.getElementById('edit-tipo').value = document.querySelector('.secondDiv div:nth-child(1) .subtitle2').textContent.trim();
            const productId = document.getElementById('delete-id-produto').value;
            document.getElementById('edit-id-produto').value = productId;
            if (previewImage) {
                previewImage.src = document.querySelector('.leftDiv img').src;
            }
            toggleEditModal();
        });
    }

    // --- Abrir Modal de Exclusão ---
    if (lixeiraIcon) {
        lixeiraIcon.addEventListener('click', toggleDeleteModal);
    }

    // --- Fechar Modais ---
    if (btnCancelarEdit) btnCancelarEdit.addEventListener('click', (e) => { e.preventDefault(); toggleEditModal(); });
    if (btnCancelarDelete) btnCancelarDelete.addEventListener('click', (e) => { e.preventDefault(); toggleDeleteModal(); });
    if (sombraForm) sombraForm.addEventListener('click', () => { if (editModal && editModal.classList.contains('formActive')) toggleEditModal(); });
    if (deleteOverlay) deleteOverlay.addEventListener('click', () => { if (deleteModal && deleteModal.classList.contains('apagarActive')) toggleDeleteModal(); });

    // --- Lógica de Troca de Imagem ---
    if (previewImage) {
        previewImage.addEventListener('click', () => {
            if (fotoInputEdit) fotoInputEdit.click();
        });
    }
    if (fotoInputEdit) {
        fotoInputEdit.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => { if (previewImage) previewImage.src = e.target.result; };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // --- Navegação do Menu Lateral ---
    const optionLinks = document.querySelectorAll('.option');
    if (optionLinks.length > 0) {
        optionLinks.forEach((op, index) => {
            op.addEventListener('click', () => {
                const urls = ['cardapio_adm.php', 'pedidosADM.php', 'empresa.php#feedback'];
                if (urls[index]) window.location.href = urls[index];
            });
        });
    }
});
