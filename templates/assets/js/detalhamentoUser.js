const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')
const back = document.querySelector('.back')
const cartPage = document.querySelector('.cartPage')
const profileButton = document.querySelector('.profileButton')
const form = document.querySelector('form')
const cartBtn = document.querySelector('.cart')
const idInput = document.querySelector('.product_id')

menu.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
})
sombra.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
})

back.addEventListener('click', () => {
    window.location.href = '../View/cardapio.php'
})

form.addEventListener('submit',(e)=>{
    e.preventDefault()
})

cartBtn.addEventListener('click', ()=>{
    idInput.value = cartBtn.id
    form.submit()
})