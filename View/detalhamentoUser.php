<?php

session_start();
require_once('../vendor/autoload.php');
use Controller\EstoqueController;
use Controller\ProductController;
use Controller\CarrinhoController;
$estoqueController = new EstoqueController();
$productController = new ProductController();
$carrinhoController = new CarrinhoController();
if($_SESSION['id_cliente'] !== null) {
    $id_cliente = $_SESSION['id_cliente'];
} else {
    header('Location: login.php');
}
$productId = $_SESSION['product_id_details'];
$product = $productController->findById($productId);
$imageBase64 = 'data:image/jpeg;base64,' . base64_encode($product['imagem_produto']);
$estoque = $estoqueController->obtEstoque($product['id_produto']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['product_id'])) {
        $id_produto = $_POST['product_id'];
        $carrinhoController->addProductToCart($id_produto, $id_cliente);
        header('Location: carrinho.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página de detalhamento | Meumanoburger</title>
        <link rel="stylesheet" href="../templates/assets/css/detalhamentoUser.css" type="text/css">
    </head>
    <body>
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
                <a href="paginaPrincipalUser.php">
                    <figure>
                        <img class="back" src="../templates/assets/img/volte.png" alt="">
                    </figure>
                </a>
                <a href="carrinho.php">
                    <figure>
                        <img class="cartPage" src="../templates/assets/img/yellowShoppingCart.png" alt="">
                    </figure>
                </a>
                <a href="perfil.php">
                    <figure>
                        <img class="profileButton" src="../templates/assets/img/Profile.png" alt="">
                    </figure>
                </a>
            </div>
        </header>
        <main>
            <div class="container">
                <div class="mainDiv">
                    <div class="leftDiv">
                        <figure>
                            <img src="<?php echo $imageBase64; ?>" alt="<?php echo $product['descricao_produto'];?>">
                        </figure>
                    </div>
                    <div class="rightDiv">
                        <h2 class="title"><?php echo $product['nome_produto']; ?></h2>
                        <p><?php echo $product['descricao_produto'];?></p>
                        <h2 class="price">R$ <?php echo number_format($product['preco_produto'],2,',','.'); ?></h2>
                        <div class="buttons">
                            <button class="cart" id="<?php echo $product['id_produto'];?>">Adicionar ao carrinho</button>
                            <button class="favorite">Adicionar aos favoritos</button>
                        </div>
                    </div>
                </div>
                <div class="secondDiv">
                    <div><h4 class="subtitle">Tipo</h4><h4 class="subtitle2"><?php echo $product['tipo_produto']; ?></h4></div>
                    <div><h4 class="subtitle">Quantidade</h4><h4 class="subtitle2"><?php echo $estoque['qtd_produto']; ?></h4></div>
                </div>
            </div>
            <form method="POST"><input class="product_id" type="hidden" name="product_id"></form>
        </main>
        <script src="../templates/assets/js/detalhamentoUser.js"></script>
  <div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
      <div class="vw-plugin-top-wrapper"></div>
    </div>
  </div>
  <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
  <script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
  </script>
    </body>
</html>
