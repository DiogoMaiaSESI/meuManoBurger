const continuarComprando = document.querySelector('.continue-shopping-btn')
const form = document.querySelector('form')
const input = document.querySelector('.datetime-input')
const button = document.querySelector('.checkout-btn')
const p = document.querySelector('.summary-card p')
const aviso = document.querySelector('.aviso')
const inputId = document.querySelector('.id_produto')

continuarComprando.addEventListener('click', () => {
    window.location.href = 'cardapio.php'
})


button.addEventListener('click',()=>{
    if(aviso === null){
        if(input.value != ''){
            let dataInput = new Date(input.value)
            let agora = new Date()
            let agoraMais30 = new Date(agora.getTime() + 30 * 60 * 1000)
            if(dataInput>agora){
                if(dataInput>agoraMais30) {
                    p.style.display = 'none'
                    form.submit()
                } else {
                    p.innerHTML = 'O pedido deve ser feito com no mínimo 30 minutos de antecedência.'
                    p.style.display = 'block'
                }
            } else {
                p.innerHTML = 'Insira dados válidos para retirada.'
                p.style.display = 'block'
            }
        } else {
            p.innerHTML = 'Por favor, insira os dados para retirada.'
            p.style.display = 'block'
        }
    } else {
        alert('Não é possível prosseguir com o carrinho vazio!')
    }
})

form.addEventListener('submit',(e)=>{
    e.preventDefault()
})

const sandwichMenu = document.querySelector('.sandwich-menu-btn');
    const sandwichOptions = document.querySelector('.options');
    const sandwichSombra = document.querySelector('.sombra');

    function toggleMenu() {
        if (sandwichOptions) sandwichOptions.classList.toggle('optionActive');
        if (sandwichSombra) sandwichSombra.classList.toggle('shadowActive');
    }

    if (sandwichMenu) sandwichMenu.addEventListener('click', toggleMenu);
    if (sandwichSombra) sandwichSombra.addEventListener('click', toggleMenu);

const buttons = document.querySelectorAll('.recommendations-grid span')

buttons.forEach((button)=>{
    button.addEventListener('click',()=>{
        inputId.value = button.id
        form.submit()
    })
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