const opcoes = document.querySelector('.options')
const menu = document.querySelector('.menu')
const sombra = document.querySelector('.sombra')
const back = document.querySelector('.back')
const cartPage = document.querySelector('.cartPage')
const profileButton = document.querySelector('.profileButton')
const sandwich = document.querySelector('.sandwich')
const finalizarCompra = document.querySelector('button')
const form = document.querySelector('form')
const input = document.querySelector('input')

menu.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
    if (sandwich.style.pointerEvents === 'none') {
        sandwich.style.pointerEvents = 'all'
    } else {
        sandwich.style.pointerEvents = 'none'
    }
})
sombra.addEventListener('click', () => {
    opcoes.classList.toggle('optionActive')
    sombra.classList.toggle('shadowActive')
    sandwich.style.pointerEvents = 'none'
})

back.addEventListener('click', () => {
    window.location.href = '../index.php'
})

finalizarCompra.addEventListener('click', () => {
    form.submit()
})

const option = document.querySelectorAll('.option')
option.forEach((op, index) => {
    op.addEventListener('click', () => {
        if (index === 0) {
            window.location.href = 'cardapio.php'
        } else if (index === 1) {
            window.location.href = 'pedidosUSER.php'
        } else if (index === 2) {
            window.location.href = 'paginaPrincipalUser.php#feedback'
        } else if (index === 3) {
            window.location.href = 'carrinho.php'
        }
    })
})
const btnPix = document.getElementById('btn-pix');
const modalPix = document.getElementById('modal-pix');

if (btnPix && modalPix) {

    const closeModalBtn = modalPix.querySelector('.close-modal');
    const qrContainer = document.getElementById('pix-qrcode-container');
    const payloadText = document.getElementById('pix-payload-text');

    btnPix.addEventListener('click', async () => {

        qrContainer.innerHTML = '<p>Gerando QR Code, por favor aguarde...</p>';
        payloadText.value = 'Aguarde...';
        modalPix.style.display = 'flex';

        try {

            const response = await fetch('api.php?action=generate_pix_qrcode');
            const data = await response.json();

            if (data.success) {

                qrContainer.innerHTML = `
                    <img src="${data.qrCodeUrl}" 
                         alt="QR Code Pix"
                         style="width: 300px; height: 300px;">
                `;

                payloadText.value = data.payload;

            } else {
                qrContainer.innerHTML = `
                    <p style="color: red; font-weight: bold;">
                        ${data.message}
                    </p>
                `;
            }

        } catch (error) {
            console.error('Erro ao gerar QR Code:', error);
            qrContainer.innerHTML = `
                <p style="color: red; font-weight: bold;">
                    Não foi possível conectar ao servidor.
                </p>`;
        }
    });

    const closeModal = () => {
        modalPix.style.display = 'none';
    };

    closeModalBtn.addEventListener('click', closeModal);

    modalPix.addEventListener('click', (e) => {
        if (e.target === modalPix) {
            closeModal();
        }
    });
}
