document.addEventListener('DOMContentLoaded', function () {
  const opcoes = document.querySelector('.options')
  const menu = document.querySelector('.menu')
  const sombra = document.querySelector('.sombra')

  const pedidos = document.querySelectorAll('.pedido')
  const statusRetiradoTexto = 'Retirado'
  const modaldetalhes = document.querySelector('.modaldetalhes')
  const fechar = document.querySelector('.fechar')
  const modalconfirm = document.querySelector('.modalconfirm')
  const modalexcluir = document.querySelector('.modalconfirmexclusion')
  const btnsim = document.querySelector('.sim')
  const btnnao = document.querySelector('.nao')
  const btnsimexcluir = document.querySelector('.simexclusion')
  const btnnaoexcluir = document.querySelector('.naoexclusion')

  form = document.querySelector('form')
  let Pedidoatual = null
  let StatusBtnatual = null
  let Statusdetalhesatual = null
  let LixeiraBtnatual = null

  form.addEventListener('submit', (e)=>{
    e.preventDefault()
  })

  menu.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
  })
  sombra.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
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

  window.addEventListener('click', (event) => {
    if (event.target == modalconfirm) {
      modalconfirm.style.display = 'none'
    }
  })

  window.addEventListener('click', (event) => {
    if (event.target == modalexcluir) {
      modalexcluir.style.display = 'none'
    }
  })



  pedidos.forEach((pedido) => {
    const form = pedido.querySelector('form')
    const detalhesBtn = pedido.querySelector('.detalhes')
    const statusBtn = pedido.querySelector('.statusbtn')
    const statusPendente = pedido.querySelector('.statuspendente')
    const statusRetirado = pedido.querySelector('.statusretirado')
    const statusCancelado = pedido.querySelector('.statuscancelado')
    const lixeiraBtn = pedido.querySelector('.lixeira')

    let codigoatual = pedido.querySelector('.codigo')
    let horaatual = pedido.querySelector('.hora')
    let dataatual = pedido.querySelector('.data')



    detalhesBtn.addEventListener('click', () => {

      let codigomodal = document.querySelector('.modaldetalhes .codigotexto')
      codigomodal.textContent = codigoatual.textContent

      let datamodal = document.querySelector('.modaldetalhes .modaldata p')
      datamodal.textContent = dataatual.textContent

      let horamodal = document.querySelector('.modaldetalhes .modalhora p')
      horamodal.textContent = horaatual.textContent

      let array = JSON.parse(detalhesBtn.dataset.array)

      const resumos = document.querySelector('.resumos')
      resumos.innerHTML = ''
      array.forEach((item)=>{
        resumos.innerHTML = resumos.innerHTML + `<div class="resumolanche"><p class="nomelanche">${item.nome_produto}</p><p class="qtdlanche">${item.qtd}x</p></div>`
      })
      let statuspedido

      if (statusPendente) {
        statuspedido = 'A retirar'
      } else if (statusRetirado) {
        statuspedido = 'Retirado'
      } else if (statusCancelado) {
        statuspedido = 'Cancelado'
      }

      const statusModal = document.querySelector('.modaldetalhes .modalstatus p')
      statusModal.textContent = statuspedido

      modaldetalhes.style.display = 'block'
    })
    if (statusBtn) {
      statusBtn.addEventListener('click', () => {
        Pedidoatual = pedido
        StatusBtnatual = statusBtn
        Statusdetalhesatual = document.querySelector('.modaldetalhes .modalstatus p')
        modalconfirm.style.display = 'block'
      })
    }
    if (lixeiraBtn) {
      lixeiraBtn.addEventListener('click',()=>{
        Pedidoatual = pedido
        LixeiraBtnatual = lixeiraBtn
        Statusdetalhesatual = document.querySelector('.modaldetalhes .modalstatus p')
        modalexcluir.style.display = 'block'
      })
    }
  })



  btnnao.addEventListener('click', () => {
    modalconfirm.style.display = 'none'
    Pedidoatual = null
    StatusBtnatual = null
  })

  btnnaoexcluir.addEventListener('click', () => {
    modalexcluir.style.display = 'none'
    Pedidoatual = null
    LixeiraBtnatual = null
  })

  btnsim.addEventListener('click', () => {
    modalconfirm.style.display = 'none'
    const codigo = Pedidoatual.querySelector('.codigo').textContent
    const inputPost = document.querySelector('.postPedido')
    const inputApagar = document.querySelector('.apagarPedido')
    inputApagar.value = null
    inputPost.value = codigo
    form.submit()
  })

  btnsimexcluir.addEventListener('click', () => {
    modalexcluir.style.display = 'none'
    const codigo = Pedidoatual.querySelector('.codigo').textContent
    const inputApagar = document.querySelector('.apagarPedido')
    const inputPost = document.querySelector('.postPedido')
    inputPost.value = null
    inputApagar.value = codigo
    form.submit()
  })
  
  const barraPesquisa = document.querySelector('input')
  const btnBuscar = document.querySelector('.btn')


  function pesquisarPedidos() {
    const texto = barraPesquisa.value.toLowerCase()

    pedidos.forEach(pedido => {
      const codigo = pedido.querySelector('.codigo').textContent.toLowerCase()
      const hora = pedido.querySelector('.hora').textContent
      const data = pedido.querySelector('.data').textContent

      if (codigo.includes(texto) || hora.includes(texto) || data.includes(texto)) {
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
        pedido.style.display = 'flex'
      })
    }
  })

  // localStorage.clear()
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