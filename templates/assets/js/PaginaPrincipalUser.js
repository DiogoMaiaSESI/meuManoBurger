const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')
const sandwich = document.querySelector('.sandwich')

menu.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
    sandwich.classList.toggle('sandwichActive') 
})
sombra.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
    sandwich.classList.toggle('sandwichActive')
})