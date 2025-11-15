
//O JS só roda depois que o DOM inteiro está feito.
document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('form');
  const inputImagem = document.getElementById("imagemProduto");
  const previewImagem = document.getElementById("previewImagem"); // Elemento de pré-visualização da imagem


  form.addEventListener("submit", function (event) { 
         event.preventDefault();
      
  const imagem = document.getElementById('imagemProduto').files.length; // Pega a quantidade de arquivos selecionados no input de imagem
  if (imagem === 0) { // Se nenhum arquivo foi selecionado
  alert('Por favor, selecione uma imagem do produto.');
  return;
  }else {
    form.submit()
      // window.location.href = "cardapiouser.php";
    }
  });


  const card = document.querySelector('.voltar')
  card.addEventListener('click', () => {
    // window.location.href = 'cardapiouser.php'
})



inputImagem.addEventListener("change", function () { // Quando o usuário seleciona um arquivo 
  const arquivo = this.files[0]; // Pega o primeiro arquivo selecionado
  if (arquivo) {
    const leitor = new FileReader(); // Cria um objeto FileReader, que serve pra ler arquivos locais (como imagens) em Js

    leitor.addEventListener("load", function () { // Quando a leitura do arquivo for concluída
      previewImagem.setAttribute("src", this.result);  // Define o src da imagem de pré-visualização como o resultado da leitura (uma URL de dados)
    });

    leitor.readAsDataURL(arquivo); // Converte o arquivo para uma URL de dados
  }
});

});

const voltar = document.querySelector('.voltar')

voltar.addEventListener('click', () => {
  window.location.href = 'cardapio.php'
})