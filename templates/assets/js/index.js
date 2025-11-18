const  home = document.querySelector('button.sessao1')
const maispedidos = document.querySelector('.sessao2')
const sobrenos = document.querySelector('.sessao3')
const feedbacks = document.querySelector('.sessao4')
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
home.addEventListener('click', () =>{
  
    if(window.innerWidth > 1100){
        window.scrollTo({
            top: 10,
            behavior: 'smooth'
        })
    }

    if(window.innerWidth > 900 && window.innerWidth <=1100) {
        window.scrollTo({
            top: 10,
            behavior: 'smooth'
        })
    }

    if(window.innerWidth > 600 && window.innerWidth <= 900){
        window.scrollTo({
            top:12,
            behavior: 'smooth'
        })
    }
})    

maispedidos.addEventListener('click', () =>{
  
    if(window.innerWidth > 1100){
        window.scrollTo({
            top: 450,
            behavior: 'smooth'
        })
    }

    if(window.innerWidth > 900 && window.innerWidth <=1100) {
        window.scrollTo({
            top: 340,
            behavior: 'smooth'
        })
    }

    if(window.innerWidth > 600 && window.innerWidth <= 900){
        window.scrollTo({
            top: 90,
            behavior: 'smooth'
        })
    }
})    

sobrenos.addEventListener('click', () =>{
  
    if(window.innerWidth > 1100){
        window.scrollTo({
            top: 1280,
            behavior: 'smooth'
        })
    }

    if(window.innerWidth > 900 && window.innerWidth <=1100) {
        window.scrollTo({
            top: 850,
            behavior: 'smooth'
        })
    }

    if(window.innerWidth > 600 && window.innerWidth <= 900){
        window.scrollTo({
            top: 580,
            behavior: 'smooth'
        })
    }
})    

feedbacks.addEventListener('click', () =>{
  
    if(window.innerWidth > 1100){
        window.scrollTo({
            top: 2150,
            behavior: 'smooth'
        })
    }

    if(window.innerWidth > 900 && window.innerWidth <=1100) {
        window.scrollTo({
            top: 1610,
            behavior: 'smooth'
        })
    }

    if(window.innerWidth > 600 && window.innerWidth <= 900){
        window.scrollTo({
            top: 1150,
            behavior: 'smooth'
        })
    }
})
    const navButtons = document.querySelectorAll('button.nav-button');
    navButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start' // Garante que o topo da seção alinhe com o topo da tela
                });
            }
        });
    });

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


