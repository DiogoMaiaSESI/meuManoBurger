const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')
const back = document.querySelector('.back')
const profileButton = document.querySelector('.profileButton')
const lapis = document.querySelector('.lapis')
const form = document.querySelector('form')
const cancelar = document.querySelector('.cancelar')
const editar = document.querySelector('.editar')

menu.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
})
sombra.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
})

back.addEventListener('click', () => {
    window.location.href = '../index.php'
})
lapis.addEventListener('click', () => {
    form.style.display = 'flex'
    sombra.classList.toggle('shadowActive')
})
cancelar.addEventListener('click', () => {
    form.style.display = 'none'
    sombra.classList.toggle('shadowActive')
})
editar.addEventListener('click', () => {
    alert('Lanche editado com sucesso!')
    form.style.display = 'none'
    sombra.classList.toggle('shadowActive')
})