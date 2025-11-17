const hambBtn = document.querySelector('.hambBtn')
const lancBtn = document.querySelector('.lancBtn')
const bebBtn = document.querySelector('.bebBtn')
const cafeBtn = document.querySelector('.cafeBtn')
const docesBtn = document.querySelector('.docesBtn')
const tapBtn = document.querySelector('.tapBtn')
const promBtn = document.querySelector('.promBtn')
const hambSection = document.querySelector('.hamb')
const lancSection = document.querySelector('.lanc')
const bebSection = document.querySelector('.beb')
const cafeSection = document.querySelector('.cafe')
const docesSection = document.querySelector('.doces')
const tapSection = document.querySelector('.tap')
const promSection = document.querySelector('.prom')
const labelHamb = document.querySelector('#hamburgueres h2')
const labelLanc = document.querySelector('#lanches h2')
const labelBeb = document.querySelector('#bebidas h2')
const labelCafe = document.querySelector('#cafe_manha h2')
const labelDoces = document.querySelector('#doces h2')
const labelTap = document.querySelector('#Tapioca h2')
const labelProm = document.querySelector('#promocoes h2')
const promHeader = document.querySelector('.h1_promocoes')
const cardaHeader = document.querySelector('.h1_cardapio')


hambBtn.addEventListener('click', () => {
    hambSection.style.display = 'block'
    lancSection.style.display = 'none'
    bebSection.style.display = 'none'
    cafeSection.style.display = 'none'
    docesSection.style.display = 'none'
    tapSection.style.display = 'none'
    promSection.style.display = 'none'
    labelHamb.style.borderBottom = '2px solid #ffcc00'
    labelLanc.style.borderBottom = 'none'
    labelBeb.style.borderBottom = 'none'
    labelCafe.style.borderBottom = 'none'
    labelDoces.style.borderBottom = 'none'
    labelTap.style.borderBottom = 'none'
    labelProm.style.borderBottom = 'none'
    cardaHeader.style.borderBottom = '0.1rem solid #FFFFFF'
    promHeader.style.borderBottom = 'none'
})
lancBtn.addEventListener('click', () => {
    hambSection.style.display = 'none'
    lancSection.style.display = 'block'
    bebSection.style.display = 'none'
    cafeSection.style.display = 'none'
    docesSection.style.display = 'none'
    tapSection.style.display = 'none'
    promSection.style.display = 'none'
    labelHamb.style.borderBottom = 'none'
    labelLanc.style.borderBottom = '2px solid #ffcc00'
    labelBeb.style.borderBottom = 'none'
    labelCafe.style.borderBottom = 'none'
    labelDoces.style.borderBottom = 'none'
    labelTap.style.borderBottom = 'none'
    labelProm.style.borderBottom = 'none'
    cardaHeader.style.borderBottom = '0.1rem solid #FFFFFF'
    promHeader.style.borderBottom = 'none'
})
bebBtn.addEventListener('click', () => {
    hambSection.style.display = 'none'
    lancSection.style.display = 'none'
    bebSection.style.display = 'block'
    cafeSection.style.display = 'none'
    docesSection.style.display = 'none'
    tapSection.style.display = 'none'
    promSection.style.display = 'none'
    labelHamb.style.borderBottom = 'none'
    labelLanc.style.borderBottom = 'none'
    labelBeb.style.borderBottom = '2px solid #ffcc00'
    labelCafe.style.borderBottom = 'none'
    labelDoces.style.borderBottom = 'none'
    labelTap.style.borderBottom = 'none'
    labelProm.style.borderBottom = 'none'
    cardaHeader.style.borderBottom = '0.1rem solid #FFFFFF'
    promHeader.style.borderBottom = 'none'
})
cafeBtn.addEventListener('click', () => {
    hambSection.style.display = 'none'
    lancSection.style.display = 'none'
    bebSection.style.display = 'none'
    cafeSection.style.display = 'block'
    docesSection.style.display = 'none'
    tapSection.style.display = 'none'
    promSection.style.display = 'none'
    labelHamb.style.borderBottom = 'none'
    labelLanc.style.borderBottom = 'none'
    labelBeb.style.borderBottom = 'none'
    labelCafe.style.borderBottom = '2px solid #ffcc00'
    labelDoces.style.borderBottom = 'none'
    labelTap.style.borderBottom = 'none'
    labelProm.style.borderBottom = 'none'
    cardaHeader.style.borderBottom = '0.1rem solid #FFFFFF'
    promHeader.style.borderBottom = 'none'
})
docesBtn.addEventListener('click', () => {
    hambSection.style.display = 'none'
    lancSection.style.display = 'none'
    bebSection.style.display = 'none'
    cafeSection.style.display = 'none'
    docesSection.style.display = 'block'
    tapSection.style.display = 'none'
    promSection.style.display = 'none'
    labelHamb.style.borderBottom = 'none'
    labelLanc.style.borderBottom = 'none'
    labelBeb.style.borderBottom = 'none'
    labelCafe.style.borderBottom = 'none'
    labelDoces.style.borderBottom = '2px solid #ffcc00'
    labelTap.style.borderBottom = 'none'
    labelProm.style.borderBottom = 'none'
    cardaHeader.style.borderBottom = '0.1rem solid #FFFFFF'
    promHeader.style.borderBottom = 'none'
})
tapBtn.addEventListener('click', () => {
    hambSection.style.display = 'none'
    lancSection.style.display = 'none'
    bebSection.style.display = 'none'
    cafeSection.style.display = 'none'
    docesSection.style.display = 'none'
    tapSection.style.display = 'block'
    promSection.style.display = 'none'
    labelHamb.style.borderBottom = 'none'
    labelLanc.style.borderBottom = 'none'
    labelBeb.style.borderBottom = 'none'
    labelCafe.style.borderBottom = 'none'
    labelDoces.style.borderBottom = 'none'
    labelTap.style.borderBottom = '2px solid #ffcc00'
    labelProm.style.borderBottom = 'none'
    cardaHeader.style.borderBottom = '0.1rem solid #FFFFFF'
    promHeader.style.borderBottom = 'none'
})
promBtn.addEventListener('click', () => {
    hambSection.style.display = 'none'
    lancSection.style.display = 'none'
    bebSection.style.display = 'none'
    cafeSection.style.display = 'none'
    docesSection.style.display = 'none'
    tapSection.style.display = 'none'
    promSection.style.display = 'block'
    labelHamb.style.borderBottom = 'none'
    labelLanc.style.borderBottom = 'none'
    labelBeb.style.borderBottom = 'none'
    labelCafe.style.borderBottom = 'none'
    labelDoces.style.borderBottom = 'none'
    labelTap.style.borderBottom = 'none'
    labelProm.style.borderBottom = '2px solid #ffcc00'
    promHeader.style.borderBottom = '0.1rem solid #FFFFFF'
    cardaHeader.style.borderBottom = 'none'
})

if (promHeader) {
    promHeader.addEventListener('click', () => {
        hambSection.style.display = 'none'
        lancSection.style.display = 'none'
        bebSection.style.display = 'none'
        cafeSection.style.display = 'none'
        docesSection.style.display = 'none'
        tapSection.style.display = 'none'
        promSection.style.display = 'block'
        labelHamb.style.borderBottom = 'none'
        labelLanc.style.borderBottom = 'none'
        labelBeb.style.borderBottom = 'none'
        labelCafe.style.borderBottom = 'none'
        labelDoces.style.borderBottom = 'none'
        labelTap.style.borderBottom = 'none'
        labelProm.style.borderBottom = '2px solid #ffcc00'
        promHeader.style.borderBottom = '0.1rem solid #FFFFFF'
        cardaHeader.style.borderBottom = 'none'
    })
}


if (cardaHeader) {
    cardaHeader.addEventListener('click', () => {
        hambSection.style.display = 'block'
        lancSection.style.display = 'none'
        bebSection.style.display = 'none'
        cafeSection.style.display = 'none'
        docesSection.style.display = 'none'
        tapSection.style.display = 'none'
        promSection.style.display = 'none'
        labelHamb.style.borderBottom = '2px solid #ffcc00'
        labelLanc.style.borderBottom = 'none'
        labelBeb.style.borderBottom = 'none'
        labelCafe.style.borderBottom = 'none'
        labelDoces.style.borderBottom = 'none'
        labelTap.style.borderBottom = 'none'
        labelProm.style.borderBottom = 'none'
        promHeader.style.borderBottom = 'none'
        cardaHeader.style.borderBottom = '0.1rem solid #FFFFFF'
    })
}


const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')
const sandwich = document.querySelector('.sandwich')
menu.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
    sandwich.classList.toggle('sandwichActive') 
})
sombra.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
    sandwich.classList.toggle('sandwichActive')
})

const addProduto = document.querySelectorAll('.adicionar_produto')

addProduto.forEach(botao => {
    botao.addEventListener('click' , () => {
        window.location.href = 'cadastro_produto.php'
    })
})