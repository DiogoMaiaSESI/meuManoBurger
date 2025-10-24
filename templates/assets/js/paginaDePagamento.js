const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')
const back = document.querySelector('.back')
const cartPage = document.querySelector('.cartPage')
const profileButton = document.querySelector('.profileButton')
const sandwich = document.querySelector('.sandwich')

menu.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
    if(sandwich.style.pointerEvents === 'none') {
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