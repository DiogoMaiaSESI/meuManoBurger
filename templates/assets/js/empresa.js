document.addEventListener('DOMContentLoaded', function () {
const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')

menu.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
})
sombra.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
})

//botão de ver cardapio
const btnCardapio = document.querySelector('.ver-cardapio')
btnCardapio.addEventListener('click', () => {
 window.location.href = 'cardapio.html'
})

//redirecoonamento para a pagina inicial pelo icone de perfil 
const perfil = document.querySelector('.perfil')
perfil.addEventListener('click', () => {
    window.location.href = 'index.html'
})

})