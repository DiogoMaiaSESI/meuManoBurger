<?php

session_start();

if($_SESSION['id_cliente'] !== null) {
    $id_cliente = $_SESSION['id_cliente'];
} else {
    header('Location: login.php');
}

use Controller\ProductController;
use Controller\CarrinhoController;
require_once('../vendor/autoload.php');
$productController = new ProductController();
$carrinhoController = new CarrinhoController();
$cartProducts = $carrinhoController->getAllCartProducts($id_cliente);
$products = [];
foreach ($cartProducts as $cartProduct) {
    $products[] = $cartProduct['id_produto_fk'];
}
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST['horario'])){
        $_SESSION['horario'] = $_POST['horario'];
        header('Location: paginaDePagamento.php');
        exit;
    }
    if(!empty($_POST['id_produto'])){
        $_SESSION['product_id_details'] = $_POST['id_produto'];
        header('Location: detalhamentoUser.php');
        exit;
    }
}
$total = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - Meu Mano Burger</title>
    
    <!-- Carregando o CSS global e o novo CSS do carrinho -->
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/global.css"> 
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/carrinho.css">

    <style>
        .sandwich-menu-container {
            position: absolute;
            top: 12.3rem;
            left: 0;
            z-index: 1002;
            pointer-events: none;
        }

        .options {
            background-color: var(--VermelhoCereja);
            width: 25.5rem;
            border: 2px solid var(--Preto);
            border-left-style: none;
            transform: translateX(-100%);
            transition: transform 500ms ease-in-out;
            border-radius: 0 1rem 1rem 0;
            pointer-events: auto;
            overflow: hidden;
        }

        .options.optionActive {
            transform: translateX(0%);
        }

        .option {
            display: flex;
            align-items: center;
            height: 6.4rem;
            border-top: 1px solid var(--Preto);
            color: var(--Branco);
            padding-left: 1.6rem;
            gap: 2.1rem;
            cursor: pointer;
            transition: padding-left 300ms;
        }

        .option:first-child {
            border-top: none;
        }

        .option:hover {
            padding-left: 2.5rem;
        }

        .option h5 {
            font-size: 2.1rem;
            font-weight: 400;
        }

        .sombra {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 1001;
            background-color: var(--Preto);
            opacity: 0;
            transition: opacity 500ms;
            pointer-events: none;
        }

        .sombra.shadowActive {
            opacity: 0.4;
            pointer-events: all;
        }

        /* ... (no final do arquivo) ... */

        /* ESTILOS PARA O MODAL 2FA */
        .qr-code-container {
            display: flex;
            justify-content: center;
            margin: 2rem 0;
            padding: 1rem;
            background-color: var(--Branco);
            border-radius: 1.2rem;
        }

        #2fa-setup-content p {
            text-align: center;
            font-size: 1.6rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        #2fa-verify-form .form-group {
            margin-bottom: 2rem;
        }

        #2fa-verify-form input {
            text-align: center;
            font-size: 2rem;
            letter-spacing: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="sandwich-menu-container">
        <div class="options">
            <div class="option">
                <figure><img src="/meuManoBurger/templates/assets/img/Cardapio.png" alt="Cardápio"></figure>
                <h5>Cardápio</h5>
            </div>
            <div class="option">
                <figure><img src="/meuManoBurger/templates/assets/img/Pedidos.png" alt="Pedidos"></figure>
                <h5>Pedidos</h5>
            </div>
            <div class="option">
                <figure><img src="/meuManoBurger/templates/assets/img/Feedbacks.png" alt="Feedbacks"></figure>
                <h5>Feedbacks</h5>
            </div>
            <div class="option">
                <figure><img src="/meuManoBurger/templates/assets/img/Carrinho_menu.png" alt="Carrinho"></figure>
                <h5>Carrinho</h5>
            </div>
        </div>
    </div>
    <div class="sombra"></div>
    <!-- Header (Estrutura mínima necessária) -->
    <header class="main-header">
        <nav class="header-nav">
            <li>
                <button class="menu-btn sandwich-menu-btn">
                    <figure><img src="/meuManoBurger/templates/assets/img/Menu.png" alt="Menu" class="icon-img">
                    </figure>
                </button>
            </li>
            <div class="logo-container">
                <img src="/meuManoBurger/templates/assets/img/Logo.png" alt="Logo Meu Mano Burger" class="logo-principal">
            </div>
            <div class="user-actions">
                <a href="paginaPrincipalUser.php" class="icon-link">
                    <img src="/meuManoBurger/templates/assets/img/Voltar.png" alt="Voltar" class="icon-img">
                </a>
                <a href="perfil.php" class="icon-link">
                    <img src="/meuManoBurger/templates/assets/img/MiniPerfil.png" alt="Perfil" class="icon-img">
                </a>
            </div>
        </nav>
    </header>

    <!-- Conteúdo Principal do Carrinho -->
    <main class="cart-container">
        
        <div class="cart-layout">
            <!-- Coluna da Esquerda: Itens do Carrinho -->
            <div class="cart-items-column">
                <div class="cart-card">
                    <h2 class="cart-title">Carrinho de compras</h2>

                    <!-- Div para o fundo rosa claro -->
                    <div class="cart-items-background">
                        <ul class="cart-item-list">
                            <?php
                            if(!empty($products)){
                                foreach ($products as $product => $value) {
                                    $prod = $productController->findById($value);
                                    $qtd = $carrinhoController->getProductById($value, $id_cliente)[0]['qtd_produto'];
                                    $total += $prod['preco_produto'] * $qtd;
                                }
                                foreach ($products as $product => $value) {
                                    $qtd = $carrinhoController->getProductById($value, $id_cliente)[0]['qtd_produto'];
                                    $prod = $productController->findById($value);
                                    $imageBase64 = 'data:image/jpeg;base64,' . base64_encode($prod['imagem_produto']);
                                    echo '<li class="cart-item">
                                    <div class="item-info">
                                        <img src="'. $imageBase64 .'" alt="Hambúrguer" class="item-image">
                                        <span class="item-name">' . $qtd . 'x ' . $prod['nome_produto'] . '</span>
                                    </div>
                                    <span class="item-price">R$ '. number_format($prod['preco_produto'],2,',','.') . '</span>
                                </li>';
                                }
                            } else {
                                echo '<h2 class="aviso">Seu carrinho está vazio!</h2>';
                            }
                            ?>
                        </ul>
                    </div>

                    <!-- Linha de separação adicionada -->
                    <hr class="cart-divider">

                    <button class="continue-shopping-btn">Continuar comprando</button>
                </div>
            </div>

            <!-- Coluna da Direita: Resumo do Pedido -->
            <div class="cart-summary-column">
                <div class="summary-card">
                    <div class="summary-total">
                        <span>Total Estimado:</span>
                        <span class="total-price">R$ <?php echo number_format($total,2,',','.'); ?></span>
                    </div>
                    <button class="checkout-btn">Continuar para o pagamento</button>
                </div>
                <div class="summary-card">
                    <div class="summary-total">
                        <span>Agende a retirada do seu pedido!</span>
                    </div>
                    <form method="POST"><input class="datetime-input" type="datetime-local" name="horario" id="horario"><input class="id_produto" type="hidden" name="id_produto"></form>
                    <p>Por favor, insira os dados para retirada</p>
                </div>
            </div>
        </div>

        <!-- Seção de Pedidos Recomendados -->
        <div class="recommendations-card">
            <h2 class="recommendations-title">Pedidos recomendados</h2>
            <div class="recommendations-grid">
                <!-- Recomendação 1 -->
                <div class="rec-item">
                    <img src="\meuManoBurger\templates\assets\img\EsfirraCarne.png" alt="Esfirra de Carne" class="rec-image">
                    <span id="17" class="rec-name">Esfirra de Carne</span>
                </div>
                <!-- Recomendação 2 -->
                <div class="rec-item">
                    <img src="\meuManoBurger\templates\assets\img\PastelFrito.png" alt="Pastel frito" class="rec-image">
                    <span id="14" class="rec-name">Pastel frito</span>
                </div>
                <!-- Recomendação 3 -->
                <div class="rec-item">
                    <img src="\meuManoBurger\templates\assets\img\CoxinhaQueijo.png" alt="Coxinha de queijo" class="rec-image">
                    <span id="16" class="rec-name">Coxinha de queijo</span>
                </div>
            </div>
        </div>

    </main>
    <script src="../templates/assets/js/carrinho.js"></script>
</body>
</html>
