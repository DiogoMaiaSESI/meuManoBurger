const continuarComprando = document.querySelector('.continue-shopping-btn')
const form = document.querySelector('form')
const input = document.querySelector('input')
const button = document.querySelector('.checkout-btn')
const p = document.querySelector('.summary-card p')

continuarComprando.addEventListener('click', () => {
    window.location.href = 'cardapio.php'
})


button.addEventListener('click',()=>{
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
})

form.addEventListener('submit',(e)=>{
    e.preventDefault()
})