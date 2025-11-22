<?php

session_start();
use Controller\ProductController;
use Controller\PedidoController;
use Controller\EstoqueController;
use Controller\CarrinhoController;
use Controller\ClienteController;
require_once('../vendor/autoload.php');
if ($_SESSION['id_cliente'] !== null) {
    $id_cliente = $_SESSION['id_cliente'];
} else {
    header('Location: login.php');
}

$productController = new ProductController();
$pedidoController = new PedidoController();
$estoqueController = new EstoqueController();
$carrinhoController = new CarrinhoController();
$clienteController = new ClienteController();

$imagemCliente = $clienteController->getClienteById($id_cliente)['imagem_cliente'];

$products = [];
$cartProducts = $carrinhoController->getAllCartProducts($id_cliente);
foreach ($cartProducts as $cartProduct) {
    $products[] = $cartProduct['id_produto_fk'];
}
$produtoSemEstoque = [];
foreach ($products as $productId) {
    $qtd = $carrinhoController->getProductById($productId, $id_cliente)[0]['qtd_produto'];
    $estoque = $estoqueController->obtEstoque($productId)['qtd_produto'];
    if($estoque - $qtd < 0) {
        $produtoSemEstoque[] = $productController->findById($productId)['nome_produto'];
    }
}

$horario = $_SESSION['horario'];
$horarioFormatado = str_replace('T', ' ', $horario) . ':00';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produtoSemEstoque = [];
    foreach ($products as $productId) {
        $qtd = $carrinhoController->getProductById($productId, $id_cliente)[0]['qtd_produto'];
        $estoque = $estoqueController->obtEstoque($productId)['qtd_produto'];
        if($estoque - $qtd < 0) {
            $produtoSemEstoque[] = $productController->findById($productId)['nome_produto'];
        }
    }
    if (!$produtoSemEstoque){
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
            $qtd = $carrinhoController->getProductById($productId, $id_cliente)[0]['qtd_produto'];
    
            // Cria o pedido com o produto e quantidade correta
            if(!empty($_POST['payment_method'])){
                $forma_pagamento = $_POST['payment_method'];
            }
            $pedidoController->criarPedido(
                $productId,
                $id_cliente,
                $codigo,
                $qtd,
                $precoTotal,
                $horarioFormatado,
                'A retirar',
                $forma_pagamento
            );
    
            // Pega o pedido criado
            $pedidoCriado = $pedidoController->getPedidoByCodigo($codigo);
            // Atualiza o estoque do pedido
            $estoqueController->subEstoque($pedidoCriado[0]['id_pedido']);
        }
        $carrinhoController->deleteAllClientCart($id_cliente);
        header('Location: pedidosUSER.php');
        exit();
    } else {
        echo '<script>alert("O(s) seguinte(s) produto(s) estão sem estoque disponível: ';
        $ultimoProduto = count($produtoSemEstoque) - 1;
        foreach($produtoSemEstoque as $index => $produto){
            if ($index != $ultimoProduto){
                echo $produto . ', ';
            } else {
                echo $produto . '.';
            }
        }
        echo'")</script>';
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
                    <figure class="perfilFigure">
                        <img class="profileButton" src="data:image/jpeg;base64,<?php echo base64_encode($imagemCliente);?>" alt="">
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
                                <figure><img class="imagemLanche" src="' . $imageBase64 . '" alt="' . $prod['descricao_produto'] . '" ></figure>
                                <h5>' . $qtd . 'x ' . $prod['nome_produto'] . '</h5>
                            </div>
                            <h4>R$ ' . number_format($prod['preco_produto'], 2, ',', '.') . '</h4>
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

        <section class="payment-method">
            <!-- Seção de Pagamento Virtual -->
            <div class="payment-group">
                <h3>Pagamento Virtual</h3>
                <div class="payment-options">
                    <div class="payment-option" data-method="Pix" id="pix-option">
                        <figure><img src="../templates/assets/img/pix.png" alt=""></figure>
                        <span>Pix</span>
                    </div>
                </div>
            </div>

            <!-- Seção de Pagamento Presencial -->
            <div class="payment-group">
                <h3>Pagamento Presencial</h3>
                <div class="payment-options">
                    <div class="payment-option" data-method="Cartão de Crédito">
                        <figure><img src="../templates/assets/img/card.png" alt=""></figure>
                        <span>Cartão de Crédito</span>
                    </div>
                    <div class="payment-option" data-method="Cartão de Débito">
                        <figure><img src="../templates/assets/img/card.png" alt=""></figure>
                        <span>Cartão de Débito</span>
                    </div>
                    <div class="payment-option" data-method="Voucher">
                        <figure><img src="../templates/assets/img/voucher.png" alt=""></figure>
                        <span>Voucher</span>
                    </div>
                </div>
            </div>
        </section>
        <form id="checkout-form" method="POST">
            <input type="hidden" id="selected-payment-method" name="payment_method" value="">
            <button type="submit">Finalizar pagamento</button>
        </form>
    </main>
    <div id="pix-modal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Pagamento via PIX</h2>
            <div class="pix-container">
                <p>Escaneie o QR Code abaixo com o app do seu banco.</p>
                <!-- Usando uma imagem estática -->
                <img src="../templates/assets/img/qrcode-fixo.png" alt="QR Code Pix Fixo" class="pix-qrcode">
            </div>
            <hr>
            <p class="important-notice">
                <strong>Atenção:</strong> Conclua o pagamento e mostre o comprovante na retirada do produto.
            </p>
        </div>
    </div>
    <script src="../templates/assets/js/paginaDePagamento.js"></script>
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