document.addEventListener('DOMContentLoaded', () => {
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
const addToCartBtns = document.querySelectorAll('.add-to-cart')
const form = document.querySelector('form')
const input = document.querySelector('.id_produto')
const optionsMenu = document.querySelector('.options');
const sombraMenu = document.querySelector('.sombra');
const menuIcon = document.querySelector('.menu');

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


const addProduto = document.querySelectorAll('.adicionar_produto')

form.addEventListener('submit',(e)=>{
    e.preventDefault()
})
addProduto.forEach(botao => {
    botao.addEventListener('click' , () => {
        window.location.href = 'cadastro_produto.php'
    })
})

addToCartBtns.forEach((btn)=>{
    btn.addEventListener('click',()=>{
        input.value = btn.dataset.id
        form.submit()
    })
})


document.querySelectorAll(".config_card").forEach(card => {
    card.addEventListener("click", () => {
        const id = card.dataset.id;
        document.querySelector(".id_produto").value = id;
        document.querySelector("form").submit();
    });
});

    // --- LÓGICA DE FILTRO DE CATEGORIAS ---
    // Seleciona todos os botões e seções de uma vez
    const categoryButtons = document.querySelectorAll('.container_menu .config_menu');
    const productSections = document.querySelectorAll('main + section'); // Seleciona todas as seções de produto
    const categoryLabels = document.querySelectorAll('.container_menu h2');
    const headerLinks = {
        cardapio: document.querySelector('.h1_cardapio'),
        promocoes: document.querySelector('.h1_promocoes')
    };

    // Função para gerenciar a visibilidade e os estilos
    function showCategory(targetSectionClass) {
        // Esconde todas as seções
        productSections.forEach(section => section.style.display = 'none');
        // Remove a borda de todos os labels
        categoryLabels.forEach(label => label.style.borderBottom = 'none');

        // Mostra a seção alvo
        const sectionToShow = document.querySelector(`.${targetSectionClass}`);
        if (sectionToShow) {
            sectionToShow.style.display = 'block';
        }

        // Adiciona a borda no label correspondente
        const labelToHighlight = document.querySelector(`#${targetSectionClass} h2, .${targetSectionClass} h2`);
        if (labelToHighlight) {
            labelToHighlight.style.borderBottom = '2px solid #ffcc00';
        }

        // Ajusta os headers
        if (targetSectionClass === 'prom') {
            headerLinks.promocoes.style.borderBottom = '0.1rem solid #FFFFFF';
            headerLinks.cardapio.style.borderBottom = 'none';
        } else {
            headerLinks.cardapio.style.borderBottom = '0.1rem solid #FFFFFF';
            headerLinks.promocoes.style.borderBottom = 'none';
        }
    }

    // Adiciona o evento de clique para cada botão de categoria
    categoryButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Extrai a classe da seção a partir do ID do botão (ex: 'hamburgueres' -> 'hamb')
            const sectionClass = button.id.substring(0, 4).replace('Tapi', 'tap');
            showCategory(sectionClass);
        });
    });

    // Eventos para os links do header
    if (headerLinks.cardapio) {
        headerLinks.cardapio.addEventListener('click', () => showCategory('hamb'));
    }
    if (headerLinks.promocoes) {
        headerLinks.promocoes.addEventListener('click', () => showCategory('prom'));
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
})