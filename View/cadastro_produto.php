<?php

session_start();
$_SESSION['idAdm'] = 1;
$_SESSION['admEmail'] = 'mariane.mmb.admin@gmail.com';
$_SESSION['admSenha'] = '123';

require_once('../vendor/autoload.php');
use Controller\ProductController;
$productController = new ProductController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nome'],$_POST['opcoes_cardapio'],$_POST['descricao'],$_POST['quantidade'],$_POST['preco'],$_POST['imagemProduto'])) {
        $nome = $_POST['nome'];
        $opcoes = $_POST['opcoes_cardapio'];
        $descricao = $_POST['descricao'];
        $quantidade = $_POST['quantidade'];
        $preco = $_POST['preco'];
        $foto = $_POST['imagemProduto'];
        $imagem = file_get_contents($foto);
        $id_adm_fk = $_SESSION['idAdm'];
        $productController->create($nome, $preco, $opcoes, $descricao, $imagem, $id_adm_fk);
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
                <form>
                    <div class="inputs">
                        <div class="foto">
                            <label for="imagemProduto">
                                <p class="adfoto"> Adicionar Foto</p>
                                <figure class="foto-do-produto">
                                    <img id="previewImagem" src="../templates/assets/img/camera.png" alt="Imagem de camera para adicionar foto do produto" />
                                </figure>
                            </label>
                            <input type="file" id="imagemProduto" name="imagemProduto" accept="image/*" style="display: none;">
                        </div>
                    </div>
                    <div class="icons">
                        <figure>
                            <img class="voltar" src="../templates/assets/img/volte.png" alt=" Imagem de uma seta de voltar ">
                        </figure>
                    </div>
                    <p class="labelInput">Nome</p>
                    <input type="text" name="nome" id="nome"  placeholder ="Nome do produto" required>
                    <p class="labelInput">Categoria</p>
                    <select name="opcoes_cardapio" id="opcoes_cardapio" required>
                        <option value="">Selecione</option>
                        <option value="2">Hambúrgueres</option>
                        <option value="3">Lanches</option>   
                        <option value="4">Bebidas</option>
                        <option value="5">Café da manhã</option>
                        <option value="6">Doces</option>
                        <option value="7">Tapioca</option>
                        <option value="8">Promoções</option>
                    </select>
                    <p class="labelInput">Descrição</p>
                    <textarea name="descricao" id="descricao" placeholder ="Descreva o seu produto aqui" required></textarea>
                    <div class="qtd-preco">
                        <div clas = "qtd">
                            <p class="labelInput">Quantidade</p>
                            <input type="number" name="quantidade" id="quantidade" placeholder ="Ex: 10" required>
                        </div>
                        <div clas = "preco">
                            <p class="labelInput">Preço</p>
                            <input type="number" name="preco" id="preco" placeholder ="Ex: 2.50" set= 0.01 required>
                        </div>
                    </div>
                    <button type="submit">Cadastrar</button>
                </form>
            </div>
        </main>
        <script src="../templates/assets/js/cadastro_produto.js"></script>
    </body>
</html>