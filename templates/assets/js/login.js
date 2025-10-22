const msgErros = document.querySelectorAll('.msg_erro');
const form = document.querySelector('form');
const input1 = document.querySelector('#email');
const input2 = document.querySelector('#password');
const button = document.querySelector('button');

form.addEventListener('submit', function(event) {
    event.preventDefault();
});

button.addEventListener('click',()=>{
    if(verificarInputs()){
        form.submit()
        window.location.href = '' //colocar a pagina para redirecionar apos o login
    }
})

const verificarInputs = () => {
    let correct = true
    const emailError = msgErros[0];
    const passError = msgErros[1];

    if(input1.value.trim() === ''){
        correct = false
        if (emailError) emailError.style.display = 'block'
    }else{
        if (emailError) emailError.style.display = 'none'
    }

    if(input2.value.trim() === ''){
        correct = false
        if (passError) passError.style.display = 'block'
    }else{
        if (passError) passError.style.display = 'none'
    }

    return correct
}