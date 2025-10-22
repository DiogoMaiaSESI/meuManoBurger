const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')

menu.addEventListener('click', () => {
    if(opcoes.style.display == 'none'){
        opcoes.style.display = 'block'
        sombra.style.display = 'block'
    }else{
        opcoes.style.display = 'none'
        sombra.style.display = 'none'
    }
})