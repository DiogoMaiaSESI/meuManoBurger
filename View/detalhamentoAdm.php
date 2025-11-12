<?php
session_start();

// --- 1. SEGURANÇA: Garante que apenas o ADM acesse esta página ---
if (!isset($_SESSION['id_adm']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php');
    exit;
}

// --- 2. INCLUSÕES E INSTÂNCIAS ---
require_once __DIR__ . '/../Model/Connection.php';
require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../Model/Estoque.php';
require_once __DIR__ . '/../Controller/ProductController.php';
require_once __DIR__ . '/../Controller/EstoqueController.php';

$productModel = new \Model\Product();
$estoqueModel = new \Model\Estoque();
$productController = new \Controller\ProductController($productModel, $estoqueModel);
$estoqueController = new \Controller\EstoqueController();

// --- 3. LÓGICA PARA BUSCAR O PRODUTO ---
$productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$productId) {
    die('Erro: ID do produto não fornecido ou inválido.');
}

$product = $productController->findById($productId);
$stock = $estoqueController->obtEstoque($productId);

if (!$product) {
    die('Erro: Produto não encontrado.');
}

// --- 4. PREPARAÇÃO DAS VARIÁVEIS PARA O HTML ---
$nomeProduto = htmlspecialchars($product['nome_produto']);
$descricaoProduto = htmlspecialchars($product['descricao_produto']);
$precoProduto = 'R$ ' . number_format($product['preco_produto'], 2, ',', '.');
$tipoProduto = htmlspecialchars($product['tipo_produto']);
$quantidadeEstoque = $stock ? $stock['qtd_produto'] : 0;
$imagemProduto = 'data:image/jpeg;base64,' . base64_encode($product['imagem_produto']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes: <?php echo $nomeProduto; ?> (Admin) | MeuManoBurger</title>
    <link rel="stylesheet" href="../templates/assets/css/detalhamentoAdm.css" type="text/css">
</head>
<body>
    <form>
            <div class="formLeft">
                <h2>Editar lanche</h2>
                <div class="inputs">
                    <div class="foto">
                        <h3>Foto</h3>
                        <figure>
                            <img src="../templates/assets/img/camera.png" alt="">
                        </figure>
                        <input type="file" name="foto" id="foto">
                    </div>
                    <div class="input">
                        <h4>Nome</h4>
                        <input type="text" placeholder="Digite o nome do lanche">
                    </div>
                    <div class="input">
                        <h4>Tipo</h4>
                        <button>Selecione o tipo do lanche <figure><img src="../templates/assets/img/seta.png" alt=""></figure></button>
                    </div>
                </div>
            </div>
            <div class="formRight">
                <div class="input">
                    <h4>Descrição</h4>
                    <textarea name="descricao" id="descricao" placeholder="Digite a descrição"></textarea>
                </div>
                <div class="input">
                    <h4>Quantidade</h4>
                    <input type="number" placeholder="Ex: 35">
                </div>
                <div class="input">
                    <h4>Preco</h4>
                    <input type="number" placeholder="Ex: 7.00" step="0.01">
                </div>
                <div class="submitBtns">
                    <button class="cancelar">Cancelar</button>
                    <button class="editar">Editar</button>
                </div>
            </div>
        </form>
        <div class="apagar">
            <div class="text">
                <h3>Confirmar exclusão</h3>
                <h4>Tem certeza que deseja deletar este lanche?</h4>
            </div>
            <div class="botoes">
                <button class="cancelar2">Cancelar</button>
                <button class="deletar">Deletar</button>
            </div>
        </div>
        <div class="sombraForm"></div>
        <div class="deleteForm"></div>
        <header>
            <div class="sandwich">
                <figure class="menu">
                    <img src="../templates/assets/img/sandwichMenu.png" alt="">
                </figure>
                <div class="options">
                    <div class="option">
                        <figure>
                            <img src="../templates/assets/img/cutlery.png" alt="">
                        </figure>
                        <h5>Cardápio</h5>
                    </div>
                    <div class="option">
                        <figure>
                            <img src="../templates/assets/img/coxinhaIcon.png" alt="">
                        </figure>
                        <h5>Pedidos</h5>
                    </div>
                    <div class="option">
                        <figure>
                            <img src="../templates/assets/img/chat.png" alt="">
                        </figure>
                        <h5>Feedbacks</h5>
                    </div>
                    <div class="option">
                        <figure>
                            <img src="../templates/assets/img/shoppingCart.png" alt="">
                        </figure>
                        <h5>Carrinho</h5>
                    </div>
                </div>
            </div>
            <div class="sombra"></div>
            <figure class="logo">
                <img src="../templates/assets/img/Logo.png" alt="">
            </figure>
            <div class="headerButtons">
                <figure>
                    <img class="back" src="../templates/assets/img/volte.png" alt="">
                </figure>
                <figure>
                    <img class="profileButton" src="../templates/assets/img/Profile.png" alt="">
                </figure>
            </div>
        </header>

    <main>
        <div class="container">
            <div class="mainDiv">
                <div class="leftDiv">
                    <figure>
                        <img src="<?php echo $imagemProduto; ?>" alt="Foto de <?php echo $nomeProduto; ?>">
                    </figure>
                </div>
                <div class="rightDiv">
                    <div class="title">
                        <h2 class="title"><?php echo $nomeProduto; ?></h2>
                        <div class="icons">
                            <figure>
                                <img class="lapis" src="../templates/assets/img/lapis.png" alt="Editar Produto">
                            </figure>
                            <figure>
                                <img class="lixeira" src="../templates/assets/img/lixeira.png" alt="Deletar Produto">
                            </figure>
                        </div>
                    </div>
                    <p><?php echo $descricaoProduto; ?></p>
                    <h2 class="price"><?php echo $precoProduto; ?></h2>
                </div>
            </div>
            <div class="secondDiv">
                <div><h4 class="subtitle">Tipo</h4><h4 class="subtitle2"><?php echo $tipoProduto; ?></h4></div>
                <div><h4 class="subtitle">Quantidade</h4><h4 class="subtitle2"><?php echo $quantidadeEstoque; ?></h4></div>
            </div>
        </div>
    </main>
    <script src="../templates/assets/js/detalhamentoAdm.js"></script>
</body>
</html>
