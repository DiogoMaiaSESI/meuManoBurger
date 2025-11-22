const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')
const back = document.querySelector('.back')
const cartPage = document.querySelector('.cartPage')
const profileButton = document.querySelector('.profileButton')
const form = document.querySelector('form')
const cartBtn = document.querySelector('.cart')
const idInput = document.querySelector('.product_id')
const favoriteBtn = document.querySelector('.favorite')
const rmFavoriteBtn = document.querySelector('.removeFavorite')
const inputFavorite = document.querySelector('.favoriteProduct')
const rmInputFavorite = document.querySelector('.rmFavoriteProduct')

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

if(favoriteBtn){
    favoriteBtn.addEventListener('click', ()=>{
        inputFavorite.value = favoriteBtn.id
        form.submit()
    })
}

if(rmFavoriteBtn){
    rmFavoriteBtn.addEventListener('click', ()=>{
        rmInputFavorite.value = rmFavoriteBtn.id
        form.submit()
    })
}