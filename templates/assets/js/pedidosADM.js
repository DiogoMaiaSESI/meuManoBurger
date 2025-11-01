const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')
const modaldetalhes = document.querySelector('.modaldetalhes')
const fechar = document.querySelector('.fechar')
const modalconfirm = document.querySelector('.modalconfirm')
const btnsim = document.querySelector('.sim')
const btnnao = document.querySelector('.nao')

let currentPedido = null
let currentStatusBtn = null

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
    modalconfirm.style.display = 'none'
  }
})

const pedidos = document.querySelectorAll('.pedido')
pedidos.forEach((pedido) => {
  const detalhesBtn = pedido.querySelector('.detalhes')
  const statusBtn = pedido.querySelector('.statusbtn')

  if (detalhesBtn) {
    detalhesBtn.addEventListener('click', () => {

      modaldetalhes.style.display = 'block'
    })
  }

  if (statusBtn) {
    statusBtn.addEventListener('click', () => {
      currentPedido = pedido
      currentStatusBtn = statusBtn
      modalconfirm.style.display = 'block'
    })
  }
})

if (btnnao) {
  btnnao.addEventListener('click', () => {
    modalconfirm.style.display = 'none'
    currentPedido = null
    currentStatusBtn = null
  })
}

const statusRetiradoText = 'Retirado'
if (btnsim) {
  btnsim.addEventListener('click', () => {
    modalconfirm.style.display = 'none'
    if (!currentPedido) return

    const retirado = currentPedido.querySelector('.statusretirado')
    const pendente = currentPedido.querySelector('.statuspendente')

    if (retirado || pendente) {
      if (pendente) pendente.style.display = 'none'
      if (retirado) retirado.style.display = 'block'
    } else {
  

      const statusOk = currentPedido.querySelector('.statusok')
      const statusPend = currentPedido.querySelector('.statuspend')
      if (statusPend) statusPend.style.display = 'none'
      if (statusOk) statusOk.style.display = 'block'
    }

    if (currentStatusBtn) currentStatusBtn.textContent = statusRetiradoText

    currentPedido = null
    currentStatusBtn = null
  })
}