
//O JS só roda depois que o DOM inteiro está feito.
document.addEventListener('DOMContentLoaded', function () {
  const msgErro = document.querySelector('.msg_erro'); 
  const form = document.querySelector('form');
  const senha = document.getElementById('password');
  const confirmarSenha = document.getElementById('confirm_password');



  form.addEventListener("submit", function (event) {
         event.preventDefault();
       if (senha.value !== confirmarSenha.value) {
        msgErro.style.display = 'block'; 
      confirmarSenha.focus(); // aqui está o "foco" no campo de confirmação, sem precisar selecionar manualmente
    }

    else {
      window.location.href = "login.php";
    }
  });
});




const inputImagem = document.getElementById("imagemPerfil");
const previewImagem = document.getElementById("previewImagem");

inputImagem.addEventListener("change", function () {
  const arquivo = this.files[0];
  if (arquivo) {
    const leitor = new FileReader();

    leitor.addEventListener("load", function () {
      previewImagem.setAttribute("src", this.result);
    });

    leitor.readAsDataURL(arquivo);
  }
});


