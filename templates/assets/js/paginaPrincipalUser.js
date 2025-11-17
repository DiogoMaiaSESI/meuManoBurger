const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')
const sandwich = document.querySelector('.sandwich')
const cardapioBtn = document.querySelector('.saibaBtn')
const lanchesBtn = document.querySelectorAll('.nomedopedido')
const input = document.querySelector('.product_id')
const form = document.querySelector('form')
const categorias = document.querySelectorAll('container_menu figure')

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

cardapioBtn.addEventListener('click', ()=>{
    window.location.href = 'cardapio.php'
})

form.addEventListener('submit',(e)=>{
    e.preventDefault()
})

lanchesBtn.forEach((btn)=>{
    btn.addEventListener('click',()=>{
        input.value = btn.id
        form.submit()
    })
})

categorias.forEach((cat)=>{
    cat.addEventListener('click', ()=>{
        
    })
})