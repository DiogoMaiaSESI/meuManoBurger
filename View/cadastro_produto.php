<?php
session_start();

if (!isset($_SESSION['id_adm']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../Model/Estoque.php';
require_once __DIR__ . '/../Controller/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productModel = new Model\Product();
    $estoqueModel = new Model\Estoque();
    $productController = new Controller\ProductController($productModel, $estoqueModel);

    $dadosProduto = [
        'nome' => $_POST['nome_produto'] ?? null,
        'preco' => $_POST['preco_produto'] ?? null,
        'tipo' => $_POST['tipo_produto'] ?? null,
        'descricao' => $_POST['descricao_produto'] ?? null,
        'quantidade' => $_POST['quantidade'] ?? null,
        'imagem' => (isset($_FILES['imagem_produto']) && $_FILES['imagem_produto']['error'] == UPLOAD_ERR_OK) ? file_get_contents($_FILES['imagem_produto']['tmp_name']) : null,
        'id_adm_fk' => $_SESSION['id_adm'] ?? null
    ];

    $result = $productController->createProductWithStock($dadosProduto);

    if ($result !== false) {
        // Sucesso! Redireciona para a página de detalhes com o ID retornado.
        header('Location: detalhamentoAdm.php?id=' . $result);
        exit;
    } else {
        // Falha! Redireciona de volta para o formulário para mostrar o erro.
        header('Location: cadastro_produto.php');
        exit;
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
                        <option value="2">Hambúrgueres</option>
                        <option value="3">Lanches</option>   
                        <option value="4">Bebidas</option>
                        <option value="5">Café da manhã</option>
                        <option value="6">Doces</option>
                        <option value="7">Tapioca</option>
                        <option value="8">Promoções</option>
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