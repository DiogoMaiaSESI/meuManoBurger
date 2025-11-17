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
const btnCardapio = document.querySelector('.btncardapio')
btnCardapio.addEventListener('click', () => {
 window.location.href = 'cardapio_adm.php'
})

//redirecoonamento para a pagina inicial pelo icone de perfil 
const perfil = document.querySelector('.perfil')
perfil.addEventListener('click', () => {
    window.location.href = 'perfil_adm.php'
})

})


const option = document.querySelectorAll('.option')
option.forEach((op, index)=>{
    op.addEventListener('click',()=>{
        if(index===0){
            window.location.href = 'cardapio_adm.php'
        }else if(index===1){
            window.location.href = 'pedidosADM.php'
        }else if(index===2){
            window.location.href = 'empresa.php#feedback'
        }
    })
})