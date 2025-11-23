document.addEventListener('DOMContentLoaded', function () {
    // --- LÓGICA DO MENU SANDUÍCHE ---
    const opcoes = document.querySelector('.options');
    const menu = document.querySelector('.menu');
    const sombra = document.querySelector('.sombra');

    if (menu) {
        menu.addEventListener('click', () => {
            opcoes.classList.toggle('optionActive');
            sombra.classList.toggle('shadowActive');
        });
    }
    if (sombra) {
        sombra.addEventListener('click', () => {
            opcoes.classList.toggle('optionActive');
            sombra.classList.toggle('shadowActive');
        });
    }

    // --- BOTÕES DE REDIRECIONAMENTO ---
    const btnCardapio = document.querySelector('.btncardapio');
    if (btnCardapio) {
        btnCardapio.addEventListener('click', () => {
            window.location.href = 'cardapio_adm.php';
        });
    }

    const perfil = document.querySelector('.perfil');
    if (perfil) {
        perfil.addEventListener('click', () => {
            window.location.href = 'perfil_adm.php';
        });
    }

    // --- [CORREÇÃO] NAVEGAÇÃO INTERNA E EXTERNA DO MENU ---
    const optionLinks = document.querySelectorAll('.option');
    optionLinks.forEach((op, index) => {
        op.addEventListener('click', () => {
            if (index === 0) {
                window.location.href = 'cardapio_adm.php';
            } else if (index === 1) {
                window.location.href = 'pedidosADM.php';
            } else if (index === 2) {
                // Lógica de rolagem suave para a seção de feedbacks
                const feedbackSection = document.getElementById('feedback');
                if (feedbackSection) {
                    feedbackSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
});
