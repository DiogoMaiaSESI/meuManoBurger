const msgErros = document.querySelectorAll('.msg_erro');
const form = document.querySelector('form');
const input1 = document.querySelector('#nome');
const input2 = document.querySelector('#email');
const input3 = document.querySelector('#password');
const input4 = document.querySelector('#confirm_password');
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
        if (nomeError) nomeError.style.display = 'block'
    }else{
        if (nomeError) nomeError.style.display = 'none'
    }

    if(input2.value.trim() === ''){
        correct = false
         if (emailError) emailError.style.display = 'block'
    }else{
        if (emailError) emailError.style.display = 'none'
    }


    
    if(input3.value.trim() === ''){
        correct = false
        if (passError) passError.style.display = 'block'
    }else{
        if (passError) passError.style.display = 'none'
    }


    
    if(input4.value.trim() === ''){
        correct = false
        if (confirmpassError) confirmpassError.style.display = 'block'
    }else{
        if (confirmpassError) confirmpassError.style.display = 'none'
    }

    return correct



    
}

