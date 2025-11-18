document.addEventListener('DOMContentLoaded', function () {

    // --- LÓGICA DO MENU SANDUÍCHE ---
    const opcoes = document.querySelector('.options');
    const menu = document.querySelector('.menu');
    const sombra = document.querySelector('.sombra');
    const sandwich = document.querySelector('.sandwich');

    if (menu && opcoes && sombra && sandwich) {
        menu.addEventListener('click', () => {
            opcoes.classList.toggle('optionActive');
            sombra.classList.toggle('shadowActive');
            sandwich.classList.toggle('sandwichActive');
        });

        sombra.addEventListener('click', () => {
            opcoes.classList.toggle('optionActive');
            sombra.classList.toggle('shadowActive');
            sandwich.classList.toggle('sandwichActive');
        });
    }

    // --- LÓGICA DO MODAL DE FEEDBACK ---
    const btnAddFeedback = document.getElementById('btn-add-feedback');
    const modal = document.getElementById('modal-feedback');

    if (btnAddFeedback && modal) {
        const closeModalBtn = modal.querySelector('.close-modal');
        const cancelModalBtn = modal.querySelector('.btn-cancel');

        btnAddFeedback.addEventListener('click', () => {
            modal.classList.add('active');
        });

        function closeModal() {
            modal.classList.remove('active');
        }

        if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);
        
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });
    }
    
    // --- LÓGICA DOS OUTROS BOTÕES E LINKS ---
    const cardapioBtn = document.querySelector('.saibaBtn');
    if (cardapioBtn) {
        cardapioBtn.addEventListener('click', () => {
            window.location.href = 'cardapio.php';
        });
    }

    const lanchesBtn = document.querySelectorAll('.nomedopedido');
    const productIdForm = document.querySelector('form:has(input.product_id)');
    if (lanchesBtn.length > 0 && productIdForm) {
        const input = productIdForm.querySelector('.product_id');
        lanchesBtn.forEach((btn) => {
            btn.addEventListener('click', () => {
                if (input) {
                    input.value = btn.id;
                    productIdForm.submit();
                }
            });
        });
    }

    const option = document.querySelectorAll('.option');
    if (option.length > 0) {
        option.forEach((op, index) => {
            op.addEventListener('click', () => {
                if (index === 0) {
                    window.location.href = 'cardapio.php';
                } else if (index === 1) {
                    window.location.href = 'pedidosUSER.php';
                } else if (index === 2) {
                    const feedbackSection = document.getElementById('feedback');
                    if (feedbackSection) {
                        feedbackSection.scrollIntoView({ behavior: 'smooth' });
                    }
                } else if (index === 3) {
                    window.location.href = 'carrinho.php';
                }
            });
        });
    }
});