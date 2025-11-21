const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')
const back = document.querySelector('.back')
const cartPage = document.querySelector('.cartPage')
const profileButton = document.querySelector('.profileButton')
const sandwich = document.querySelector('.sandwich')
const finalizarCompra = document.querySelector('button')
const form = document.querySelector('form')
const input = document.querySelector('input')

menu.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
    if (sandwich.style.pointerEvents === 'none') {
        sandwich.style.pointerEvents = 'all'
    } else {
        sandwich.style.pointerEvents = 'none'
    }
})
sombra.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
    sandwich.style.pointerEvents = 'none'
})

back.addEventListener('click', () => {
    window.location.href = '../index.php'
})

finalizarCompra.addEventListener('click', () => {
    form.submit()
})

const option = document.querySelectorAll('.option')
option.forEach((op, index) => {
    op.addEventListener('click', () => {
        if (index === 0) {
            window.location.href = 'cardapio.php'
        } else if (index === 1) {
            window.location.href = 'pedidosUSER.php'
        } else if (index === 2) {
            window.location.href = 'paginaPrincipalUser.php#feedback'
        } else if (index === 3) {
            window.location.href = 'carrinho.php'
        }
    })
})
const paymentOptions = document.querySelectorAll('.payment-option');
    const selectedPaymentInput = document.getElementById('selected-payment-method');
    const checkoutForm = document.getElementById('checkout-form');

    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove a classe 'selected' de todas as opções
            paymentOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Adiciona a classe 'selected' apenas na opção clicada
            this.classList.add('selected');
            
            // Pega o método de pagamento do atributo 'data-method'
            const selectedMethod = this.dataset.method;
            
            // Atualiza o valor do campo oculto no formulário
            selectedPaymentInput.value = selectedMethod;
        });
    });

    // --- Lógica do Modal PIX ---
    const pixOption = document.getElementById('pix-option');
    const pixModal = document.getElementById('pix-modal');
    const closeModalBtn = pixModal.querySelector('.close-modal');

    if (pixOption) {
        pixOption.addEventListener('click', function() {
            // Abre o modal
            pixModal.classList.add('active');
        });
    }

    // Funções para fechar o modal
    const closeModal = () => pixModal.classList.remove('active');
    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
    pixModal.addEventListener('click', (event) => {
        // Fecha se clicar fora do conteúdo do modal
        if (event.target === pixModal) {
            closeModal();
        }
    });

    // --- Validação do Formulário ao Finalizar ---
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(event) {
            if (!selectedPaymentInput.value) {
                alert('Por favor, selecione um método de pagamento.');
                event.preventDefault(); // Impede o envio do formulário se nada for selecionado
            }
        });
    }


