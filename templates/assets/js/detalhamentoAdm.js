const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')
const sombraForm = document.querySelector('.sombraForm')
const deleteForm = document.querySelector('.deleteForm')
const back = document.querySelector('.back')
const profileButton = document.querySelector('.profileButton')
const lapis = document.querySelector('.lapis')
const lixeira = document.querySelector('.lixeira')
const form = document.querySelector('form')
const apagar = document.querySelector('.apagar')
const cancelar = document.querySelector('.cancelar')
const cancelar2 = document.querySelector('.cancelar2')
const editar = document.querySelector('.editar')
const deletar = document.querySelector('.deletar')

menu.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
})
sombra.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
})

sombraForm.addEventListener('click', () => {
    form.classList.toggle('formActive')
    sombraForm.classList.toggle('shadowFormActive')
})
deleteForm.addEventListener('click', () => {
    apagar.classList.toggle('apagarActive')
    deleteForm.classList.toggle('deleteFormActive')
})

back.addEventListener('click', () => {
    window.location.href = '../index.php'
})
lapis.addEventListener('click', () => {
    form.classList.toggle('formActive')
    sombraForm.classList.toggle('shadowFormActive')
})
cancelar.addEventListener('click', () => {
    form.classList.toggle('formActive')
    sombraForm.classList.toggle('shadowFormActive')
})
editar.addEventListener('click', () => {
    alert('Lanche editado com sucesso!')
    form.classList.toggle('formActive')
    sombraForm.classList.toggle('shadowFormActive')
})
lixeira.addEventListener('click', () => {
    apagar.classList.toggle('apagarActive')
    deleteForm.classList.toggle('deleteFormActive')
})
cancelar2.addEventListener('click', () => {
    apagar.classList.toggle('apagarActive')
    deleteForm.classList.toggle('deleteFormActive')
})
deletar.addEventListener('click', () => {
    alert('Lanche deletado com sucesso!')
    apagar.classList.toggle('apagarActive')
    deleteForm.classList.toggle('deleteFormActive')
})

form.addEventListener('submit', (e) => {
    e.preventDefault()
})