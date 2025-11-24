const login = document.querySelector('.login')
const lancheBtns = document.querySelectorAll('.nomedopedido')

lancheBtns.forEach(btn => {
    btn.addEventListener('click',()=>{
        window.location.href = 'View/login.php'
    })
})
login.addEventListener('click', ()=>{
    window.location.href = 'View/login.php'
})
// --- NAVEGAÇÃO SUAVE ---
const navButtons = document.querySelectorAll('button.nav-button');
    navButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });


    // --- BOTÕES DE LOGIN E PRODUTOS ---
    const loginButton = document.querySelector('button.login');
    if (loginButton) {
        loginButton.addEventListener('click', () => {
            window.location.href = 'View/login.php';
        });
    }

    const productButtons = document.querySelectorAll('.nomedopedido');
    productButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Para um usuário não logado, o melhor é levá-lo para o login.
            window.location.href = 'View/login.php';
        });
    });


