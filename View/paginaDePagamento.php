<?php

session_start();
use Controller\ProductController;
use Controller\PedidoController;
use Controller\EstoqueController;
use Controller\CarrinhoController;
require_once('../vendor/autoload.php');
if($_SESSION['id_cliente'] !== null) {
    $id_cliente = $_SESSION['id_cliente'];
} else {
    header('Location: login.php');
}
$productController = new ProductController();
$pedidoController = new PedidoController();
$estoqueController = new EstoqueController();
$carrinhoController = new CarrinhoController();

$products = [];
$cartProducts = $carrinhoController->getAllCartProducts($id_cliente);
foreach ($cartProducts as $cartProduct) {
    $products[] = $cartProduct['id_produto_fk'];
}

$horario = $_SESSION['horario'];
$horarioFormatado = str_replace('T', ' ', $horario) . ':00';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Gera o código inicial
    $codigo = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 3)
            . '-' .
              substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 1);

    // Garante que o código não existe
    while (!empty($pedidoController->getPedidoByCodigo($codigo))) {
        $codigo = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 3)
                . '-' .
                  substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 1);
    }

    // Calcula o preço total apenas UMA VEZ (não precisa fazer dentro do foreach)
    $precoTotal = 0;
    foreach ($products as $prodId) {
        $prod = $productController->findById($prodId);
        $qtd = $carrinhoController->getProductById($prodId, $id_cliente)[0]['qtd_produto'];
        $precoTotal += $prod['preco_produto'] * $qtd;
    }

    // Cria o pedido e os itens
    foreach ($products as $productId) {

        // Conta quantas vezes esse produto aparece
        $qtd = $carrinhoController->getProductById($prodId, $id_cliente)[0]['qtd_produto'];

        // Cria o pedido com o produto e quantidade correta
        $pedidoController->criarPedido(
            $productId,
            $id_cliente,
            $codigo,
            $qtd,
            $precoTotal,
            $horarioFormatado,
            'A retirar'
        );

        // Pega o pedido criado
        $pedidoCriado = $pedidoController->getPedidoByCodigo($codigo);
        // Atualiza o estoque do pedido
        $estoqueController->subEstoque($pedidoCriado[0]['id_pedido']);
    }

    header('Location: pedidosUSER.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página de pagamento | Meumanoburger</title>
        <link rel="stylesheet" href="../templates/assets/css/paginaDePagamento.css">
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
                <a href="paginaPrincipalEmpresa.php">
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
            <div class="orderSummary">
                <div class="titleDiv">
                    <h2>Seu Carrinho</h2>
                    <div class="line"></div>
                </div>
                <div class="backgroundDiv">
                    <?php 
                    $total = 0;
                    foreach ($products as $product => $value) {
                        $prod = $productController->findById($value);
                        $qtd = $carrinhoController->getProductById($value, $id_cliente)[0]['qtd_produto'];
                        $total += $prod['preco_produto'] * $qtd;
                    }
                    foreach ($products as $product => $value) {
                        $prod = $productController->findById($value);
                        $qtd = $carrinhoController->getProductById($value, $id_cliente)[0]['qtd_produto'];
                        $imageBase64 = 'data:image/jpeg;base64,' . base64_encode($prod['imagem_produto']);
                        echo '<div class="lineDiv">
                        <div class="unitDiv">
                            <div class="priceDiv">
                                <figure><img class="imagemLanche" src="'. $imageBase64 .'" alt="'. $prod['descricao_produto'] .'" ></figure>
                                <h5>'. $qtd . 'x ' . $prod['nome_produto'] .'</h5>
                            </div>
                            <h4>R$ '. number_format($prod['preco_produto'], 2, ',', '.') .'</h4>
                        </div>
                        <div class="tinyLine"></div>
                    </div>';
                    } ?>
                    <h3>Total: <span>R$ <?php echo number_format($total, 2, ',', '.'); ?></span></h3>
                </div>
            </div>
            <div class="titleDiv">
                <h2>Método de Pagamento</h2>
                <div class="line"></div>
            </div>
            <div class="paymentMethod">
                <div class="card">
                    <div class="cardContainer">
                        <figure><img src="../templates/assets/img/pix.png" alt=""></figure>
                        <h4>Pix</h4>
                    </div>
                </div>
                <div class="card">
                    <div class="cardContainer">
                        <figure><img src="../templates/assets/img/card.png" alt=""></figure>
                        <h4>Cartão de Crédito</h4>
                    </div>
                </div>
                <div class="card">
                    <div class="cardContainer">
                        <figure><img src="../templates/assets/img/card.png" alt=""></figure>
                        <h4>Cartão de Débito</h4>
                    </div>
                </div>
                <div class="card">
                    <div class="cardContainer">
                        <figure><img src="../templates/assets/img/voucher.png" alt=""></figure>
                        <h4>Voucher</h4>
                    </div>
                </div>
            </div>
            <form method="post"></form>
            <button>Finalizar pagamento</button>
        </main>
        <script src="../templates/assets/js/paginaDePagamento.js"></script>
    </body>
</html>