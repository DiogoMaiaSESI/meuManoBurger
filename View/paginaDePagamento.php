<?php

session_start();
use Controller\ProductController;
use Controller\PedidoController;
require_once('../vendor/autoload.php');
$productController = new ProductController();
$pedidoController = new PedidoController();
$products = $_SESSION['cart'];
$sair = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 3) . '-' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 1);
    while($sair !== true) {
        if(empty($pedidoController->getPedidoByCodigo($codigo))) {
            foreach ($products as $product => $value) {
                $pedidoController->criarPedido($value, 1, $codigo, 4, 1);
            }
            $sair = true;
            header('Location: pedidosUser.php');
            exit();   
        }else{
            $codigo = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 3) . '-' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 1);
            $sair = false;
        }
    }
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
                <figure>
                    <img class="back" src="../templates/assets/img/volte.png" alt="">
                </figure>
                <figure>
                    <img class="cartPage" src="../templates/assets/img/yellowShoppingCart.png" alt="">
                </figure>
                <figure>
                    <img class="profileButton" src="../templates/assets/img/Profile.png" alt="">
                </figure>
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
                        $total += $prod['preco_produto'];
                        $imageBase64 = 'data:image/jpeg;base64,' . base64_encode($prod['imagem_produto']);
                        echo '<div class="lineDiv">
                        <div class="unitDiv">
                            <div class="priceDiv">
                                <figure><img class="imagemLanche" src="'. $imageBase64 .'" alt="'. $prod['descricao_produto'] .'" ></figure>
                                <h5>'. $prod['nome_produto'] .'</h5>
                            </div>
                            <h4>R$ '. number_format($prod['preco_produto'], 2, ',', '.') .'</h4>
                        </div>
                        <div class="tinyLine"></div>
                    </div>';
                    } ?>
                    <h3>Total: <span>R$ <?php echo $total; ?></span></h3>
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