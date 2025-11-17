const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')
const back = document.querySelector('.back')
const cartPage = document.querySelector('.cartPage')
const profileButton = document.querySelector('.profileButton')
const sandwich = document.querySelector('.sandwich')
const finalizarCompra = document.querySelector('button')
const form = document.querySelector('form')
const input = document.querySelector('input')

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

finalizarCompra.addEventListener('click', () => {
    form.submit()
})

const option = document.querySelectorAll('.option')
option.forEach((op, index)=>{
    op.addEventListener('click',()=>{
        if(index===0){
            window.location.href = 'cardapio.php'
        }else if(index===1){
            window.location.href = 'pedidosUSER.php'
        }else if(index===2){
            window.location.href = 'paginaPrincipalUser.php#feedback'
        }else if(index===3){
            window.location.href = 'carrinho.php'
        }
    })
})