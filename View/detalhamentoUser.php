<?php
session_start();

require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../Model/Estoque.php';
require_once __DIR__ . '/../Controller/ProductController.php';
require_once __DIR__ . '/../Controller/EstoqueController.php';

$productModel = new \Model\Product();
$estoqueModel = new \Model\Estoque();
$productController = new \Controller\ProductController($productModel, $estoqueModel);
$estoqueController = new \Controller\EstoqueController();

$productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$productId) {
    die('Erro: ID do produto não fornecido ou inválido.');
}

$product = $productController->findById($productId);
$stock = $estoqueController->obtEstoque($productId);

if (!$product) {
    die('Erro: Produto não encontrado.');
}

$nomeProduto = htmlspecialchars($product['nome_produto']);
$descricaoProduto = htmlspecialchars($product['descricao_produto']);
$precoProduto = 'R$ ' . number_format($product['preco_produto'], 2, ',', '.');
$tipoProduto = htmlspecialchars($product['tipo_produto']);
$quantidadeEstoque = $stock ? $stock['qtd_produto'] : 0;
$imagemProduto = 'data:image/jpeg;base64,' . base64_encode($product['imagem_produto']);

$isClienteLoggedIn = isset($_SESSION['id_cliente']);
$urlPerfil = 'login.php'; // Se não estiver logado, o botão de perfil leva para o login.

// 2. Verificamos se é um administrador.
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
    $urlPerfil = 'perfil_adm.php'; // Se for admin, o link aponta para o perfil do admin.
}
// 3. Se não for admin, verificamos se é um cliente.
elseif (isset($_SESSION['id_cliente'])) {
    $urlPerfil = 'Perfil.php'; // Se for cliente, aponta para o perfil do cliente.
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes: <?php echo $nomeProduto; ?> | Meumanoburger</title>
    <link rel="stylesheet" href="../templates/assets/css/detalhamentoUser.css" type="text/css">
</head>

<body>
    <header>
        <div class="sandwich">
            <figure class="menu"> <img src="../templates/assets/img/sandwichMenu.png" alt=""> </figure>
            <div class="options">
                <div class="option">
                    <figure> <img src="../templates/assets/img/cutlery.png" alt=""> </figure>
                    <h5>Cardápio</h5>
                </div>
                <div class="option">
                    <figure> <img src="../templates/assets/img/coxinhaIcon.png" alt=""> </figure>
                    <h5>Pedidos</h5>
                </div>
                <div class="option">
                    <figure> <img src="../templates/assets/img/chat.png" alt=""> </figure>
                    <h5>Feedbacks</h5>
                </div>
                <div class="option">
                    <figure> <img src="../templates/assets/img/shoppingCart.png" alt=""> </figure>
                    <h5>Carrinho</h5>
                </div>
            </div>
        </div>
        <div class="sombra"></div>
        <figure class="logo"> <img src="../templates/assets/img/Logo.png" alt=""> </figure>
        <div class="headerButtons">
            <figure> <img class="back" src="../templates/assets/img/volte.png" alt=""> </figure>
            <figure> <img class="cartPage" src="../templates/assets/img/yellowShoppingCart.png" alt=""> </figure>
            <a href="<?php echo $urlPerfil; ?>">
                <figure class="perfil_header">
                    <img src="../templates/assets/img/perfil.png" alt="Foto de perfil" />
                </figure>
            </a>
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
                    <h2 class="title"><?php echo $nomeProduto; ?></h2>
                    <p><?php echo $descricaoProduto; ?></p>
                    <h2 class="price"><?php echo $precoProduto; ?></h2>
                    <div class="buttons">
                        <button class="cart">Adicionar ao carrinho</button>
                        <button class="favorite">Adicionar aos favoritos</button>
                    </div>
                </div>
            </div>
            <div class="secondDiv">
                <div>
                    <h4 class="subtitle">Tipo</h4>
                    <h4 class="subtitle2"><?php echo $tipoProduto; ?></h4>
                </div>
                <div>
                    <h4 class="subtitle">Quantidade</h4>
                    <h4 class="subtitle2"><?php echo $quantidadeEstoque; ?></h4>
                </div>
            </div>
        </div>
    </main>
    <script src="../templates/assets/js/detalhamentoUser.js"></script>
</body>

</html>