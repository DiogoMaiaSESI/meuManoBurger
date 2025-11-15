const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')
const sombraForm = document.querySelector('.sombraForm')
const deleteForm = document.querySelector('.deleteForm')
const back = document.querySelector('.back')
const profileButton = document.querySelector('.profileButton')
const lapis = document.querySelector('.lapis')
const lixeira = document.querySelector('.lixeira')
const form = document.querySelector('form')
const apagar = document.querySelector('.apagar')
const cancelar = document.querySelector('.cancelar')
const cancelar2 = document.querySelector('.cancelar2')
const editar = document.querySelector('.editar')
const deletar = document.querySelector('.deletar')
const figImg = document.querySelector('.foto figure img')
const fotoInput = document.querySelector('#foto')
const lapisIcon = document.querySelector('.lapis');
const lixeiraIcon = document.querySelector('.lixeira');
const editModal = document.getElementById('edit-product-form');
const deleteModal = document.querySelector('.apagar');
const deleteFormOverlay = document.querySelector('.deleteForm');
const btnCancelarEdit = editModal.querySelector('.cancelar');
const btnCancelarDelete = deleteModal.querySelector('.cancelar2');

menu.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
})
sombra.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
})

sombraForm.addEventListener('click', () => {
    form.classList.toggle('formActive')
    sombraForm.classList.toggle('shadowFormActive')
})
deleteForm.addEventListener('click', () => {
    apagar.classList.toggle('apagarActive')
    deleteForm.classList.toggle('deleteFormActive')
})

back.addEventListener('click', () => {
    window.location.href = '../index.php'
})
lapis.addEventListener('click', () => {
    form.classList.toggle('formActive')
    sombraForm.classList.toggle('shadowFormActive')
})
cancelar.addEventListener('click', () => {
    form.classList.toggle('formActive')
    sombraForm.classList.toggle('shadowFormActive')
})
editar.addEventListener('click', () => {
    alert('Lanche editado com sucesso!')
    form.classList.toggle('formActive')
    sombraForm.classList.toggle('shadowFormActive')
})
lixeira.addEventListener('click', () => {
    apagar.classList.toggle('apagarActive')
    deleteForm.classList.toggle('deleteFormActive')
})
cancelar2.addEventListener('click', () => {
    apagar.classList.toggle('apagarActive')
    deleteForm.classList.toggle('deleteFormActive')
})
deletar.addEventListener('click', () => {
    alert('Lanche deletado com sucesso!')
    apagar.classList.toggle('apagarActive')
    deleteForm.classList.toggle('deleteFormActive')
})

form.addEventListener('submit', (e) => {
    e.preventDefault()
})

figImg.addEventListener('click', () => {
    fotoInput.click()
})
function toggleEditModal() {
    editModal.classList.toggle('formActive');
    sombraForm.classList.toggle('shadowFormActive');
}

function toggleDeleteModal() {
    deleteModal.classList.toggle('apagarActive');
    deleteFormOverlay.classList.toggle('deleteFormActive');
}

lapisIcon.addEventListener('click', () => {
    const nomeAtual = document.querySelector('.rightDiv .title h2').textContent.trim();
    const descricaoAtual = document.querySelector('.rightDiv p').textContent.trim();
    const precoAtual = document.querySelector('.rightDiv .price').textContent.replace('R$', '').replace(',', '.').trim();
    const tipoAtual = document.querySelector('.secondDiv div:nth-child(1) .subtitle2').textContent.trim();
    const quantidadeAtual = document.querySelector('.secondDiv div:nth-child(2) .subtitle2').textContent.trim();
    const imagemAtualSrc = document.querySelector('.leftDiv img').src;

    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    document.getElementById('edit-nome').value = nomeAtual;
    document.getElementById('edit-descricao').value = descricaoAtual;
    document.getElementById('edit-preco').value = parseFloat(precoAtual);
    document.getElementById('edit-quantidade').value = parseInt(quantidadeAtual);
    document.getElementById('edit-tipo').value = tipoAtual; // O <select> vai selecionar a option com este value
    document.getElementById('edit-id-produto').value = productId;
    document.getElementById('edit-preview-img').src = imagemAtualSrc;

    toggleEditModal();
});

lixeiraIcon.addEventListener('click', toggleDeleteModal);

btnCancelarEdit.addEventListener('click', toggleEditModal);
btnCancelarDelete.addEventListener('click', toggleDeleteModal);
sombraForm.addEventListener('click', () => {
    if (editModal.classList.contains('formActive')) {
        toggleEditModal();
    }
});
deleteFormOverlay.addEventListener('click', () => {
    if (deleteModal.classList.contains('apagarActive')) {
        toggleDeleteModal();
    }
});

editModal.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(editModal);

    try {
        const response = await fetch('/meuManoBurger/View/api_adm.php?action=update_product', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert('Produto atualizado com sucesso!');
            window.location.reload();
            alert('Erro ao atualizar o produto: ' + (result.message || 'Verifique os campos.'));
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Ocorreu um erro de comunicação. Tente novamente.');
    }
});

const btnDeletar = deleteModal.querySelector('.deletar');
btnDeletar.addEventListener('click', async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

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
            alert('Erro ao deletar o produto: ' + (result.message || 'Tente novamente.'));
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Ocorreu um erro de comunicação.');
    }
});