<?php
session_start();
use Controller\ProductController;
require_once('../vendor/autoload.php');
$productController = new ProductController();
$products = $_SESSION['cart'];
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['horario'] = $_POST['horario'];
    header('Location: paginaDePagamento.php');
    exit;
}
if($products !== null) {
    $uniqueProducts = array_unique($products);
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
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/Carrinho.css">
</head>

<body>
    <!-- Header (Estrutura mínima necessária) -->
    <header class="main-header">
        <nav class="header-nav">
            <button class="menu-btn">
                <img src="/meuManoBurger/templates/assets/img/Menu.png" alt="Menu" class="icon-img">
            </button>
            <div class="logo-container">
                <img src="/meuManoBurger/templates/assets/img/Logo.png" alt="Logo Meu Mano Burger" class="logo-principal">
            </div>
            <div class="user-actions">
                <a href="#" class="icon-link">
                    <img src="/meuManoBurger/templates/assets/img/Voltar.png" alt="Voltar" class="icon-img">
                </a>
                <a href="#" class="icon-link">
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
                            foreach ($products as $product => $value) {
                                $prod = $productController->findById($value);
                                $total += $prod['preco_produto'];
                            }
                            foreach ($uniqueProducts as $product => $value) {
                                $qtd = count(array_filter($products, fn($product) => $product == $value));
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
                    <form method="POST"><input class="datetime-input" type="datetime-local" name="horario" id="horario"></form>
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
                    <span class="rec-name">Esfirra de Carne</span>
                </div>
                <!-- Recomendação 2 -->
                <div class="rec-item">
                    <img src="\meuManoBurger\templates\assets\img\PastelFrito.png" alt="Pastel frito" class="rec-image">
                    <span class="rec-name">Pastel frito</span>
                </div>
                <!-- Recomendação 3 -->
                <div class="rec-item">
                    <img src="\meuManoBurger\templates\assets\img\CoxinhaQueijo.png" alt="Coxinha de queijo" class="rec-image">
                    <span class="rec-name">Coxinha de queijo</span>
                </div>
            </div>
        </div>

    </main>
    <script src="../templates/assets/js/Carrinho.js"></script>
</body>
</html>
