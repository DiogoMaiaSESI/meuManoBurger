document.addEventListener('DOMContentLoaded', function () {
  const opcoes = document.querySelector('.options')
  const menu = document.querySelector('.menu')
  const sombra = document.querySelector('.sombra')
  const modaldetalhes = document.querySelector('.modaldetalhes')
  const fechar = document.querySelector('.fechar')
  const modalconfirm = document.querySelector('.modalconfirm')
  const btnsim = document.querySelector('.sim')
  const btnnao = document.querySelector('.nao')
  const barraPesquisa = document.querySelector('input[type="text"]')
  const btnBuscar = document.querySelector('.btn')
  const todosPedidos = document.querySelectorAll('.pedido')

  let Pedidoatual = null
  let StatusBtnatual = null
  let Statusdetalhesatual = null

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
  const pedidos = document.querySelectorAll('.pedido')
  const statusRetiradoTexto = 'Retirado'

  function carregarEstados() {

    pedidos.forEach((pedido) => {

      const codigo = pedido.querySelector('.codigo').textContent
      const estadoSalvo = localStorage.getItem(`pedido_${codigo}`)

      if (estadoSalvo === 'retirado') {
        const retirado = pedido.querySelector('.statusretirado')
        const pendente = pedido.querySelector('.statuspendente')
        const statusBtn = pedido.querySelector('.statusbtn')

        pendente.style.display = 'none'
        retirado.style.display = 'block'
        statusBtn.textContent = statusRetiradoTexto
        statusBtn.disabled = true
        statusBtn.classList.add('statusbtndesabilitado')
      }
    })
  }


  carregarEstados()

  pedidos.forEach((pedido) => {
    const detalhesBtn = pedido.querySelector('.detalhes')
    const statusBtn = pedido.querySelector('.statusbtn')
    const statusPendente = pedido.querySelector('.statuspendente')

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

      let statuspedido

      if (statusPendente.style.display !== 'none') {
        statuspedido = 'A retirar'
      }
      else {
        statuspedido = 'Retirado'
      }

      const statusModal = document.querySelector('.modaldetalhes .modalstatus p')
      statusModal.textContent = statuspedido

      modaldetalhes.style.display = 'block'
    })

    statusBtn.addEventListener('click', () => {
      Pedidoatual = pedido
      StatusBtnatual = statusBtn
      Statusdetalhesatual = document.querySelector('.modaldetalhes .modalstatus p')
      modalconfirm.style.display = 'block'
    })
  })

  btnnao.addEventListener('click', () => {
    modalconfirm.style.display = 'none'
    Pedidoatual = null
    StatusBtnatual = null
  })

  btnsim.addEventListener('click', () => {
    modalconfirm.style.display = 'none'
    if (!Pedidoatual) return

    const retirado = Pedidoatual.querySelector('.statusretirado')
    const pendente = Pedidoatual.querySelector('.statuspendente')
    const codigo = Pedidoatual.querySelector('.codigo').textContent

    pendente.style.display = 'none'
    retirado.style.display = 'block'

    StatusBtnatual.textContent = statusRetiradoTexto
    Statusdetalhesatual.textContent = statusRetiradoTexto
    StatusBtnatual.disabled = true
    StatusBtnatual.classList.add('statusbtndesabilitado')


    localStorage.setItem(`pedido_${codigo}`, 'retirado')

    Pedidoatual = null
    StatusBtnatual = null
    Statusdetalhesatual = null
  })


  function pesquisarPedidos() {
    const texto = barraPesquisa.value.toLowerCase()

    todosPedidos.forEach(pedido => {
      const codigo = pedido.querySelector('.codigo').textContent.toLowerCase()

      if (codigo.includes(texto)) {
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
      todosPedidos.forEach(pedido => {
        pedido.style.display = 'flex'
      })
    }
  })

  // localStorage.clear();
});