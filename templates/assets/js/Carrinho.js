const continuarComprando = document.querySelector('.continue-shopping-btn')
const finalizarCompra = document.querySelector('.checkout-btn')

continuarComprando.addEventListener('click', () => {
    window.location.href = 'cardapio.php'
})
finalizarCompra.addEventListener('click', () => {
    window.location.href = 'paginaDePagamento.php'
})
