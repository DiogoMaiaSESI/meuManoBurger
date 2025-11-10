<?php

require_once('../vendor/autoload.php');
use Controller\ProductController;
use Controller\AdmController;
use Controller\EstoqueController;

session_start();

$productController = new ProductController();
$admController = new AdmController();
$estoqueController = new EstoqueController();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nome_produto'],$_POST['tipo_produto'],$_POST['descricao_produto'],$_POST['quantidade'],$_POST['preco_produto']) && $_FILES['imagem_produto']['error'] === UPLOAD_ERR_OK) {
        $nome = $_POST['nome_produto'];
        $opcoes = $_POST['tipo_produto'];
        $descricao = $_POST['descricao_produto'];
        $quantidade = $_POST['quantidade'];
        $preco = $_POST['preco_produto'];
        $foto = $_FILES['imagem_produto']['tmp_name'];
        $imagem = file_get_contents($foto);
        $id_adm_fk = $_SESSION['idAdm'];
        $productController->create($nome, $preco, $opcoes, $descricao, $imagem, $id_adm_fk);
        $produtos = $productController->listAll();
        $ultimoProduto = end($produtos);
        $id_produto = $ultimoProduto['id_produto'];
        $estoqueController->insEstoque($quantidade, $id_produto);
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../templates/assets/css/cadastro_produto.css">
        <link rel="icon" href="../templates/assets/img/logo.png">
        <title>Cadastro de Produto | MeuManoBurger</title>
    </head>
    <body>
        <main>
            <div class="logo">
                <img src="../templates/assets/img/logo.png" alt="A logo do MeuManoBurger">
            </div>
            <div class="formContainer">
                <h1>Cadastre seu novo produto</h1>
                <form method="POST" enctype="multipart/form-data">
                    <div class="inputs">
                        <div class="foto">
                            <label for="imagemProduto">
                                <p class="adfoto"> Adicionar Foto</p>
                                <figure class="foto-do-produto">
                                    <img id="previewImagem" src="../templates/assets/img/camera.png" alt="Imagem de camera para adicionar foto do produto" />
                                </figure>
                            </label>
                            <input type="file" id="imagemProduto" name="imagem_produto" accept="image/*" style="display: none;">
                        </div>
                    </div>
                    <div class="icons">
                        <figure>
                            <img class="voltar" src="../templates/assets/img/volte.png" alt=" Imagem de uma seta de voltar ">
                        </figure>
                    </div>
                    <p class="labelInput">Nome</p>
                    <input type="text" name="nome_produto" id="nome"  placeholder ="Nome do produto" required>
                    <p class="labelInput">Categoria</p>
                    <select name="tipo_produto" id="opcoes_cardapio" required>
                        <option value="">Selecione</option>
                        <option value="Hamburgueres">Hambúrgueres</option>
                        <option value="Lanches">Lanches</option>   
                        <option value="Bebidas">Bebidas</option>
                        <option value="Café da manhã">Café da manhã</option>
                        <option value="Doces">Doces</option>
                        <option value="Tapioca">Tapioca</option>
                        <option value="Promoções">Promoções</option>
                    </select>
                    <p class="labelInput">Descrição</p>
                    <textarea name="descricao_produto" id="descricao" placeholder ="Descreva o seu produto aqui" required></textarea>
                    <div class="qtd-preco">
                        <div clas = "qtd">
                            <p class="labelInput">Quantidade</p>
                            <input type="number" name="quantidade" id="quantidade" placeholder ="Ex: 10" required>
                        </div>
                        <div clas = "preco">
                            <p class="labelInput">Preço</p>
                            <input type="number" name="preco_produto" id="preco" placeholder ="Ex: 2.50" step= 0.01 required>
                        </div>
                    </div>
                    <button type="submit">Cadastrar</button>
                </form>
            </div>
        </main>
        <script src="../templates/assets/js/cadastro_produto.js"></script>
    </body>
</html>