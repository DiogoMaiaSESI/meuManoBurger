<?php
// Futuramente, aqui você pode carregar os itens do carrinho do banco de dados
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - Meu Mano Burger</title>
    

    <link rel="stylesheet" href="\meuManoBurger\templates\assets\css\Carrinho.css">
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
                    <img src="/meuManoBurger/templates/assets/img/Carrinho.png" alt="Carrinho" class="icon-img">
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
                    <ul class="cart-item-list">
                        <!-- Item 1 -->
                        <li class="cart-item">
                            <div class="item-info">
                                <img src="/meuManoBurger/templates/assets/img/Hamburguer.png" alt="Hambúrguer" class="item-image">
                                <span class="item-name">Hambúrguer</span>
                            </div>
                            <span class="item-price">R$ 12,00</span>
                        </li>
                        <!-- Item 2 -->
                        <li class="cart-item">
                            <div class="item-info">
                                <img src="/meuManoBurger/templates/assets/img/Coxinha.png" alt="Coxinha" class="item-image">
                                <span class="item-name">Coxinha</span>
                            </div>
                            <span class="item-price">R$ 7,00</span>
                        </li>
                    </ul>
                    <button class="continue-shopping-btn">Continuar comprando</button>
                </div>
            </div>

            <!-- Coluna da Direita: Resumo do Pedido -->
            <div class="cart-summary-column">
                <div class="summary-card">
                    <div class="summary-total">
                        <span>Total Estimado:</span>
                        <span class="total-price">R$ 19,00</span>
                    </div>
                    <p class="summary-description">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <button class="checkout-btn">Continuar para o pagamento</button>
                </div>
            </div>
        </div>

        <!-- Seção de Pedidos Recomendados -->
        <div class="recommendations-card">
            <h2 class="recommendations-title">Pedidos recomendados</h2>
            <div class="recommendations-grid">
                <!-- Recomendação 1 -->
                <div class="rec-item">
                    <img src="/meuManoBurger/templates/assets/img/esfiha.jpg" alt="Esfirra de Carne" class="rec-image">
                    <span class="rec-name">Esfirra de Carne</span>
                </div>
                <!-- Recomendação 2 -->
                <div class="rec-item">
                    <img src="/meuManoBurger/templates/assets/img/pastel.jpg" alt="Pastel frito" class="rec-image">
                    <span class="rec-name">Pastel frito</span>
                </div>
                <!-- Recomendação 3 -->
                <div class="rec-item">
                    <img src="/meuManoBurger/templates/assets/img/coxinha-queijo.jpg" alt="Coxinha de queijo" class="rec-image">
                    <span class="rec-name">Coxinha de queijo</span>
                </div>
            </div>
        </div>

    </main>

</body>
</html>
