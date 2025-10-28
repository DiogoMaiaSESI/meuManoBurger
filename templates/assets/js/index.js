const  home = document.querySelector('button.sessao1')
const maispedidos = document.querySelector('.sessao2')
const sobrenos = document.querySelector('.sessao3')
const feedbacks = document.querySelector('.sessao4')


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
            top: 1150,
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
            top: 2000,
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