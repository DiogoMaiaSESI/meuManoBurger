// [BLOCO DE SEGURANÇA] Espera o HTML inteiro ser carregado antes de executar qualquer coisa.
document.addEventListener('DOMContentLoaded', function () {

    // --- Seletores Únicos e Centralizados ---
    // [NOTA] Cada variável aponta para um único elemento no seu HTML. Sem duplicatas.
    const menuIcon = document.querySelector('.menu');
    const backButton = document.querySelector('.back');
    const lapisIcon = document.querySelector('.lapis');
    const lixeiraIcon = document.querySelector('.lixeira');
    
    const optionsMenu = document.querySelector('.options');
    const sombraMenu = document.querySelector('.sombra');
    const sombraForm = document.querySelector('.sombraForm');
    const deleteFormOverlay = document.querySelector('.deleteForm');

    // [PONTO CRÍTICO] Seleciona os modais pelos IDs e classes que definimos no HTML.
    const editModal = document.getElementById('edit-product-form');
    const deleteModal = document.querySelector('.apagar');

    if (!menuIcon || !backButton || !lapisIcon || !lixeiraIcon || !editModal || !deleteModal) {
        console.error("ERRO FATAL: Um ou mais elementos essenciais da página (ícones, modais) não foram encontrados. O script não pode continuar. Verifique os seletores e o HTML.");
        return;
    }

    const btnCancelarEdit = editModal.querySelector('.cancelar');
    const btnConfirmEdit = editModal.querySelector('.editar');
    const btnCancelarDelete = deleteModal.querySelector('.cancelar2');
    const btnConfirmDelete = deleteModal.querySelector('.deletar');
    const figContainerEdit = editModal.querySelector('.foto figure');
    const fotoInputEdit = editModal.querySelector('#edit-foto-input');

    const toggleSideMenu = () => {
        optionsMenu.classList.toggle('optionActive');
        sombraMenu.classList.toggle('shadowActive');
    };
    const toggleEditModal = () => {
        editModal.classList.toggle('formActive');
        sombraForm.classList.toggle('shadowFormActive');
    };
    const toggleDeleteModal = () => {
        deleteModal.classList.toggle('apagarActive');
        deleteFormOverlay.classList.toggle('deleteFormActive');
    };

    menuIcon.addEventListener('click', toggleSideMenu);
    sombraMenu.addEventListener('click', toggleSideMenu);
    backButton.addEventListener('click', () => window.history.back());

    lapisIcon.addEventListener('click', () => {
        document.getElementById('edit-nome').value = document.querySelector('.rightDiv .title h2').textContent.trim();
        document.getElementById('edit-descricao').value = document.querySelector('.rightDiv p').textContent.trim();
        document.getElementById('edit-preco').value = parseFloat(document.querySelector('.rightDiv .price').textContent.replace('R$', '').replace(',', '.').trim());
        document.getElementById('edit-quantidade').value = parseInt(document.querySelector('.secondDiv div:nth-child(2) .subtitle2').textContent.trim());
        document.getElementById('edit-tipo').value = document.querySelector('.secondDiv div:nth-child(1) .subtitle2').textContent.trim();
        document.getElementById('edit-id-produto').value = new URLSearchParams(window.location.search).get('id');
        figContainerEdit.src = document.querySelector('.leftDiv img').src;
        toggleEditModal();
    });
    lixeiraIcon.addEventListener('click', toggleDeleteModal);

    btnCancelarEdit.addEventListener('click', toggleEditModal);
    sombraForm.addEventListener('click', () => editModal.classList.contains('formActive') && toggleEditModal());
    btnCancelarDelete.addEventListener('click', toggleDeleteModal);
    deleteFormOverlay.addEventListener('click', () => deleteModal.classList.contains('apagarActive') && toggleDeleteModal());

    figContainerEdit.addEventListener('click', () => fotoInputEdit.click());
    fotoInputEdit.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => { figContainerEdit.src = e.target.result; };
            reader.readAsDataURL(this.files[0]);
        }
    });

    editModal.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(editModal);
        try {
            const response = await fetch('/meuManoBurger/View/api_adm.php?action=update_product', { method: 'POST', body: formData });
            const result = await response.json();
            if (result.success) {
                alert('Produto atualizado com sucesso!');
                window.location.reload();
            } else {
                alert('Erro ao atualizar: ' + (result.message || 'Verifique os campos.'));
            }
        } catch (error) {
            alert('Erro de comunicação ao editar.');
        }
    });

    btnConfirmDelete.addEventListener('click', async () => {
        const productId = new URLSearchParams(window.location.search).get('id');
        try {
            const response = await fetch('/meuManoBurger/View/api_adm.php?action=delete_product', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id_produto: productId })
            });
            const result = await response.json();
            if (result.success) {
                alert('Produto deletado com sucesso!');
                window.location.href = 'cardapioAdm.php';
            } else {
                alert('Erro ao deletar: ' + (result.message || 'Tente novamente.'));
            }
        } catch (error) {
            alert('Erro de comunicação ao deletar.');
        }
    });
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