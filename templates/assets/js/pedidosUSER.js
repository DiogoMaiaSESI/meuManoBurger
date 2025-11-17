document.addEventListener('DOMContentLoaded', function () {

  const pedidosRemovidos = JSON.parse(localStorage.getItem('pedidosRemovidos')) || []

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

  const modaldetalhes = document.querySelector('.modaldetalhes')
  const modalcancelar = document.querySelector('.modalcancelar')
  const fechar = document.querySelector('.fechar')
  const pedidos = document.querySelectorAll('.pedido')
  const btnsim = document.querySelector('.sim')
  const btnnao = document.querySelector('.nao')
  let Pedidoatual = null

  pedidos.forEach((pedido) => {

    const codigo = pedido.querySelector('.codigo').textContent;
    if (pedidosRemovidos.includes(codigo)) {
      pedido.style.display = 'none'
    }
  })

  if (fechar) {
    fechar.addEventListener('click', () => {
      modaldetalhes.style.display = 'none'
    })
  }

  window.addEventListener('click', (event) => {
    if (event.target == modaldetalhes) {
      modaldetalhes.style.display = 'none'
    }
  })

  pedidos.forEach((pedido) => {
    const form = pedido.querySelector('form')
    const detalhesBtn = pedido.querySelector('.detalhes')
    const statusPendente = pedido.querySelector('.statuspendente')
    const cancelar = pedido.querySelector('.cancelar')
    let codigoatual = pedido.querySelector('.codigo')
    let horaatual = pedido.querySelector('.hora')
    let dataatual = pedido.querySelector('.data')
    form.addEventListener('submit', (e)=>{
      e.preventDefault()
    })

    if (pedidosRemovidos.includes(codigoatual.textContent)) {
      return;
    }

    detalhesBtn.addEventListener('click', () => {
      let codigomodal = document.querySelector('.modaldetalhes .codigotexto')
      codigomodal.textContent = codigoatual.textContent

      let datamodal = document.querySelector('.modaldetalhes .modaldata p')
      datamodal.textContent = dataatual.textContent

      let horamodal = document.querySelector('.modaldetalhes .modalhora p')
      horamodal.textContent = horaatual.textContent

      let statuspedido = statusPendente.style.display !== 'none' ? 'A retirar' : 'Retirado'

      const statusModal = document.querySelector('.modaldetalhes .modalstatus p')
      statusModal.textContent = statuspedido

      modaldetalhes.style.display = 'block'
    })

    cancelar.addEventListener('click', () => {
      Pedidoatual = pedido
      modalcancelar.style.display = 'block'
    })
  })

  btnnao.addEventListener('click', () => {
    modalcancelar.style.display = 'none'
    Pedidoatual = null
  })

  btnsim.addEventListener('click', () => {
    modalcancelar.style.display = 'none'
    const codigo = Pedidoatual.querySelector('.codigo').textContent
    const inputApagar = Pedidoatual.querySelector('.apagarPedido')
    const inputPost = Pedidoatual.querySelector('.postPedido')
    const form = Pedidoatual.querySelector('form')
    inputPost.value = null
    inputApagar.value = codigo
    form.submit()
      const codigoPedido = Pedidoatual.querySelector('.codigo').textContent;
      pedidosRemovidos.push(codigoPedido);
      localStorage.setItem('pedidosRemovidos', JSON.stringify(pedidosRemovidos));
      
      Pedidoatual.style.display = 'none'
      Pedidoatual = null

  })

  const barraPesquisa = document.querySelector('input')
  const btnBuscar = document.querySelector('.btn')
  
  function pesquisarPedidos() {
    const texto = barraPesquisa.value.toLowerCase()

    pedidos.forEach(pedido => {
      const codigo = pedido.querySelector('.codigo').textContent.toLowerCase()
      const hora = pedido.querySelector('.hora').textContent
      const data = pedido.querySelector('.data').textContent

      const foiRemovido = pedidosRemovidos.includes(pedido.querySelector('.codigo').textContent);

      if ((codigo.includes(texto) || hora.includes (texto) || data.includes(texto)) && foiRemovido===false) {
        pedido.style.display = 'flex'
      } else {
        pedido.style.display = 'none'
      }
    })
  }

  btnBuscar.addEventListener('click', pesquisarPedidos)

  barraPesquisa.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      pesquisarPedidos()
    }
  })

  barraPesquisa.addEventListener('input', function () {
    if (this.value === '') {
      pedidos.forEach(pedido => {
        const codigo = pedido.querySelector('.codigo').textContent;
        const foiRemovido = pedidosRemovidos.includes(codigo);
      
        if (!foiRemovido) {
          pedido.style.display = 'flex'
        } else {
          pedido.style.display = 'none'
        }
      })
    }
  })
})
// localStorage.removeItem('pedidosRemovidos')
// localStorage.clear()

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