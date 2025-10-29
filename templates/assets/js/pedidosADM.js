const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')
const btndetalhes = document.querySelector('.detalhes')
const btnstatusbtn = document.querySelector('.statusbtn')
const modaldetalhes = document.querySelector('.modaldetalhes')
const fechar = document.querySelector('.fechar')

menu.addEventListener('click', () => {
opcoes.classList.toggle('optionActive')
sombra.classList.toggle('shadowActive')
})
sombra.addEventListener('click', () => {
opcoes.classList.toggle('optionActive')
sombra.classList.toggle('shadowActive')
})

btndetalhes.addEventListener('click', () => {
    modaldetalhes.style.display = "block"
})

fechar.addEventListener('click', () => {
    modaldetalhes.style.display = "none"
})

window.addEventListener('click', (event) => {
  if (event.target == modaldetalhes) {
    modaldetalhes.style.display = "none";
  }
})