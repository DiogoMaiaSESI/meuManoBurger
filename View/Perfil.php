<?php





?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - Meu Mano Burger</title>
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/Perfil.css">
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/FormasPagamento.css">
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/MeusFavoritos.css">
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/Seguranca.css">
</head>
<body>

    <header class="main-header">
        <div class="header-content">
            <div class="header-left">
                <button class="menu-btn"><figure><img src="/meuManoBurger/templates/assets/img/Menu.png" alt="Menu" class="icon-img"></figure></button>
            </div>
            <div class="header-center">
                <figure class="logo-container"><img src="/meuManoBurger/templates/assets/img/Logo.png" alt="Logo Meu Mano Burger" class="logo-principal"></figure>
            </div>
            <nav class="header-right">
                <a href="#" class="icon-link"><figure><img src="/meuManoBurger/templates/assets/img/Voltar.png" alt="Voltar" class="icon-img"></figure></a>
                <a href="#" class="icon-link"><figure><img src="/meuManoBurger/templates/assets/img/Carrinho.png" alt="Carrinho" class="icon-img"></figure></a>
                <a href="#" class="icon-link"><figure><img src="/meuManoBurger/templates/assets/img/MiniPerfil.png" alt="Perfil" class="icon-img"></figure></a>
            </nav>
        </div>
    </header>

    <main class="profile-container">
        
        <aside class="sidebar">
            <div class="sidebar-header"><p>Olá, Beanca!</p></div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#" id="btn-dados" class="nav-link active">Meus dados</a></li>
                    <li><a href="#" id="btn-historico" class="nav-link">Histórico de Pedidos</a></li>
                    <li><a href="#" id="btn-favoritos" class="nav-link">Meus Favoritos</a></li>
                    <li><a href="#" id="btn-pagamento" class="nav-link">Formas de Pagamento</a></li>
                    <li><a href="#" id="btn-seguranca" class="nav-link">Segurança</a></li>
                    <li><a href="#" id="btn-sair" class="nav-link">Sair da Conta</a></li>
                </ul>
            </nav>
        </aside>

        <section class="content-area">
            
            <div id="content-dados" class="content-tab active">
                <div class="form-card">
                    <div class="form-top-section">
                        <div class="form-header"><h2>Meus Dados</h2></div>
                        <div class="profile-picture-container">
                            <figure><img src="/meuManoBurger/templates/assets/img/FotoPerfil.png" alt="Foto de Perfil" class="profile-picture"></figure>
                            <button type="button" class="edit-picture-btn"><figure><img src="/meuManoBurger/templates/assets/img/Edicao.png" alt="Editar Foto" class="icon-img icon-editar"></figure></button>
                        </div>
                    </div>
                    <form class="profile-form" method="POST" action="">
                        <div class="form-group"><label for="nome">Nome</label><input type="text" id="nome" name="nome" value="Beanca Adidas Ford Honda Fiat"></div>
                        <div class="form-group"><label for="email">Email</label><input type="email" id="email" name="email" value="Bia1234@gmail.com"></div>
                        <button type="submit" class="submit-btn">Salvar Alterações</button>
                    </form>
                </div>
            </div>

            <div id="content-pagamento" class="content-tab">
                <div class="form-card">
                    <div class="form-header"><h2>Formas de Pagamento</h2></div>
                    <div class="payment-methods-list">
                        <div class="payment-method-item"><figure class="payment-icon-figure"><img src="/meuManoBurger/templates/assets/img/IconeCartao.png" alt="Ícone de Cartão" class="payment-icon"></figure><span>Cartão de Crédito 2 (Mastercard)</span></div>
                        <div class="payment-method-item"><figure class="payment-icon-figure"><img src="/meuManoBurger/templates/assets/img/IconeCartao.png" alt="Ícone de Cartão" class="payment-icon"></figure><span>Cartão de Débito 2 (VISA)</span></div>
                    </div>
                    <button type="button" class="add-payment-btn">Adicionar forma de pagamento</button>
                </div>
            </div>

            <div id="content-favoritos" class="content-tab">
                <div class="form-card">
                    <div class="form-header"><h2>Meus Favoritos</h2></div>
                    <div class="favorites-grid">
                        <div class="favorite-card">
                            <figure><img src="/meuManoBurger/templates/assets/img/lanche-triplo.png" alt="Triplo Cheddar"></figure>
                            <h3>Triplo Cheddar</h3>
                            <span class="price">R$ 7,00</span>
                            <button class="details-btn"><img src="/meuManoBurger/templates/assets/img/Carrinho.png"> Ver detalhes</button>
                        </div>
                        <div class="favorite-card">
                            <figure><img src="/meuManoBurger/templates/assets/img/coxinha.png" alt="Coxinha"></figure>
                            <h3>Coxinha</h3>
                            <span class="price">R$ 7,00</span>
                            <button class="details-btn"><img src="/meuManoBurger/templates/assets/img/Carrinho.png"> Ver detalhes</button>
                        </div>
                        <div class="favorite-card">
                            <figure><img src="/meuManoBurger/templates/assets/img/pastel.png" alt="Pastel de Carne"></figure>
                            <h3>Pastel de Carne</h3>
                            <span class="price">R$ 7,00</span>
                            <button class="details-btn"><img src="/meuManoBurger/templates/assets/img/Carrinho.png"> Ver detalhes</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="content-seguranca" class="content-tab">
                <div class="form-card">
                    <div class="form-header"><h2>Segurança</h2></div>
                    <div class="security-section">
                        <h3>Autenticação de 2 Fatores (2FA)</h3>
                        <a href="#" class="add-2fa-link">+ Adicionar método de autenticação</a>
                    </div>
                    <form class="security-form" method="POST" action="">
                        <h3>Alterar senha</h3>
                        <div class="form-group password-group">
                            <input type="password" id="nova-senha" name="nova-senha" placeholder="Nova senha">
                            <img src="/meuManoBurger/templates/assets/img/olhofechado.png" class="password-toggle-icon" alt="Mostrar/Ocultar Senha">
                        </div>
                        <div class="form-group password-group">
                            <input type="password" id="confirmar-senha" name="confirmar-senha" placeholder="Confirmação de nova senha">
                            <img src="/meuManoBurger/templates/assets/img/olhofechado.png" class="password-toggle-icon" alt="Mostrar/Ocultar Senha">
                        </div>
                        <button type="submit" class="submit-btn">Salvar Alterações</button>
                    </form>
                </div>
            </div>

        </section>
    </main>

    <script src="/meuManoBurger/templates/assets/js/perfil.js"></script>

</body>
</html>
