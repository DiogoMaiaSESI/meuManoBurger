document.addEventListener('DOMContentLoaded', function() {

    // --- LÓGICA DE MANIPULAÇÃO DE ITENS (NOVA) ---
    
    // Função reutilizável para enviar comandos para a API do carrinho
    async function updateCart(action, productId) {
        try {
            const response = await fetch(`/meuManoBurger/View/api.php?action=${action}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id_produto: productId })
            });
            const result = await response.json();
            if (result.success) {
                window.location.reload(); // Recarrega a página para mostrar as mudanças
            } else {
                alert('Erro: ' + (result.message || 'Não foi possível atualizar o carrinho.'));
            }
        } catch (error) {
            console.error('Erro de comunicação:', error);
            alert('Ocorreu um erro de comunicação com o servidor.');
        }
    }

    // Adiciona os eventos de clique para os botões +, - e Remover de cada item
    document.querySelectorAll('.cart-item').forEach(item => {
        const productId = item.dataset.productId;

        const addBtn = item.querySelector('.add-btn');
        const subtractBtn = item.querySelector('.subtract-btn');
        const removeBtn = item.querySelector('.remove-item-btn');

        if (addBtn) {
            addBtn.addEventListener('click', () => updateCart('cart_add', productId));
        }
        if (subtractBtn) {
            subtractBtn.addEventListener('click', () => updateCart('cart_subtract', productId));
        }
        if (removeBtn) {
            removeBtn.addEventListener('click', () => {
                if (confirm('Tem certeza que deseja remover este item do carrinho?')) {
                    updateCart('cart_remove', productId);
                }
            });
        }
    });


    // --- SEU CÓDIGO ORIGINAL (INTEGRADO E SEGURO) ---

    const continuarComprando = document.querySelector('.continue-shopping-btn');
    const formHorario = document.querySelector('form:has(input[name="horario"])');
    const inputHorario = document.querySelector('.datetime-input');
    const checkoutButton = document.querySelector('.checkout-btn');
    const pMensagem = document.querySelector('.summary-card p');
    const avisoCarrinhoVazio = document.querySelector('.aviso');
    const inputIdProdutoRecomendado = document.querySelector('.id_produto');

    if (continuarComprando) {
        continuarComprando.addEventListener('click', () => {
            window.location.href = 'cardapio.php';
        });
    }

    if (checkoutButton) {
        checkoutButton.addEventListener('click', () => {
            if (avisoCarrinhoVazio !== null) {
                alert('Não é possível prosseguir com o carrinho vazio!');
                return;
            }
            
            if (inputHorario && inputHorario.value !== '') {
                let dataInput = new Date(inputHorario.value);
                let agora = new Date();
                let agoraMais30 = new Date(agora.getTime() + 30 * 60 * 1000);

                if (dataInput > agora) {
                    if (dataInput > agoraMais30) {
                        if(pMensagem) pMensagem.style.display = 'none';
                        if(formHorario) formHorario.submit();
                    } else {
                        if(pMensagem) {
                            pMensagem.innerHTML = 'O pedido deve ser feito com no mínimo 30 minutos de antecedência.';
                            pMensagem.style.display = 'block';
                        }
                    }
                } else {
                    if(pMensagem) {
                        pMensagem.innerHTML = 'Insira dados válidos para retirada.';
                        pMensagem.style.display = 'block';
                    }
                }
            } else {
                if(pMensagem) {
                    pMensagem.innerHTML = 'Por favor, insira os dados para retirada.';
                    pMensagem.style.display = 'block';
                }
            }
        });
    }

    if (formHorario) {
        formHorario.addEventListener('submit', (e) => {
            // A validação é feita no clique do botão, mas podemos manter isso por segurança
            if (!inputHorario || inputHorario.value === '') {
                e.preventDefault();
            }
        });
    }

    const sandwichMenu = document.querySelector('.sandwich-menu-btn');
    const sandwichOptions = document.querySelector('.options');
    const sandwichSombra = document.querySelector('.sombra');

    function toggleMenu() {
        if (sandwichOptions) sandwichOptions.classList.toggle('optionActive');
        if (sandwichSombra) sandwichSombra.classList.toggle('shadowActive');
    }

    if (sandwichMenu) sandwichMenu.addEventListener('click', toggleMenu);
    if (sandwichSombra) sandwichSombra.addEventListener('click', toggleMenu);

    const recButtons = document.querySelectorAll('.recommendations-grid span');
    const formRecomendado = document.querySelector('form:has(input.id_produto)'); // Form específico
    if (recButtons.length > 0 && formRecomendado) {
        recButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const inputTarget = formRecomendado.querySelector('.id_produto');
                if (inputTarget) {
                    inputTarget.value = button.id;
                    formRecomendado.submit();
                }
            });
        });
    }

    const option = document.querySelectorAll('.option');
    if (option.length > 0) {
        option.forEach((op, index) => {
            op.addEventListener('click', () => {
                if (index === 0) window.location.href = 'cardapio.php';
                else if (index === 1) window.location.href = 'pedidosUSER.php';
                else if (index === 2) window.location.href = 'paginaPrincipalUser.php#feedback';
                else if (index === 3) window.location.href = 'carrinho.php';
            });
        });
    }
});
