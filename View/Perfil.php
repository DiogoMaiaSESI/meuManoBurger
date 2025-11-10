<?php
// seu código PHP aqui, se houver
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
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/ModalPagamento.css">
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

    <main id="profile-container" class="profile-container">
        
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
                <figure>
                    <!-- Dê um ID à imagem para que o JS possa encontrá-la facilmente -->
                    <img src="/meuManoBurger/templates/assets/img/FotoPerfil.png" alt="Foto de Perfil" id="profile-pic-preview" class="profile-picture">
                </figure>

                <!-- O input de arquivo, escondido -->
                <input type="file" id="file-upload-input" accept="image/png, image/jpeg, image/webp" style="display: none;">

                <!-- O botão de edição que aciona o input -->
                <button type="button" id="edit-pic-btn" class="edit-picture-btn">
                    <figure><img src="/meuManoBurger/templates/assets/img/Edicao.png" alt="Editar Foto" class="icon-img icon-editar"></figure>
                </button>

                <!-- Botões de Salvar/Cancelar, escondidos inicialmente -->
                <div id="pic-action-buttons" class="pic-action-buttons">
                    <button id="save-pic-btn" class="btn-save-pic">Salvar</button>
                    <button id="cancel-pic-btn" class="btn-cancel-pic">Cancelar</button>
                </div>
            </div>
                    </div>
                    <!-- ID CORRIGIDO AQUI -->
                    <form id="profile-form" class="profile-form" method="POST" action="">
                        <div class="form-group"><label for="nome">Nome</label><input type="text" id="nome" name="nome" value="Beanca Adidas Ford Honda Fiat"></div>
                        <div class="form-group"><label for="email">Email</label><input type="email" id="email" name="email" value="Bia1234@gmail.com"></div>
                        <button type="submit" class="submit-btn">Salvar Alterações</button>
                    </form>
                </div>
            </div>

            <div id="content-pagamento" class="content-tab">
                <div class="form-card">
                    <div class="form-header"><h2>Formas de Pagamento</h2></div>
                    <div id="payment-methods-list" class="payment-methods-list"></div>
                    <button type="button" class="add-payment-btn">Adicionar forma de pagamento</button>
                </div>
            </div>

            <div id="content-favoritos" class="content-tab">
                <div class="form-card">
                    <div class="form-header"><h2>Meus Favoritos</h2></div>
                    <div class="favorites-grid">
                        <div class="favorite-card">
                            <figure><img src="\meuManoBurger\templates\assets\img\Hamburguer.png" alt="Triplo Cheddar"></figure>
                            <h3>Triplo Cheddar</h3>
                            <span class="price">R$ 7,00</span>
                            <button class="details-btn"><img src="/meuManoBurger/templates/assets/img/Carrinho.png"> Ver detalhes</button>
                        </div>
                        <div class="favorite-card">
                            <figure><img src="\meuManoBurger\templates\assets\img\Coxinha.png" alt="Coxinha"></figure>
                            <h3>Coxinha</h3>
                            <span class="price">R$ 7,00</span>
                            <button class="details-btn"><img src="/meuManoBurger/templates/assets/img/Carrinho.png"> Ver detalhes</button>
                        </div>
                        <div class="favorite-card">
                            <figure><img src="\meuManoBurger\templates\assets\img\Pastel.png" alt="Pastel de Carne"></figure>
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
                    <form id="security-form" class="security-form" method="POST" action="">
                        <h3>Alterar senha</h3>
                        <div class="form-group password-group">
                            <input type="password" id="nova-senha" name="nova-senha" placeholder="Nova senha">
                            <img src="/meuManoBurger/templates/assets/img/olhofechado.png" class="password-toggle-icon" alt="Mostrar/Ocultar Senha">
                        </div>
                        <div class="form-group password-group">
                            <input type="password" id="confirmar-senha" name="confirmar-senha" placeholder="Confirmação de nova senha">
                            <img src="/meuManoBurger/templates/assets/img/olhofechado.png" class="password-toggle-icon" alt="Mostrar/Ocultar Senha">
                        </div>
                        <button type="submit" id="btn-salvar-senha" class="submit-btn">Salvar Alterações</button>
                        <div id="password-error-message" class="error-message"></div>
                    </form>
                </div>
            </div>

        </section>

        <div id="modal-add-card" class="modal-overlay">
            <div class="modal-content">
                <button class="close-modal-btn">&times;</button>
                <h2 id="modal-title">Adicionar novo cartão</h2>
                <form id="card-form" method="POST" action="">
                    <div class="form-group">
                        <label for="card-nickname">Nome para o Cartão</label>
                        <input type="text" id="card-nickname" name="card-nickname" placeholder="Ex: Cartão Principal, Cartão da Empresa" required>
                    </div>
                    <div class="form-group">
                        <label for="card-number">Número do Cartão</label>
                        <div class="card-input-wrapper">
                            <input type="text" id="card-number" name="card-number" placeholder="0000 0000 0000 0000" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="card-expiry">Validade</label>
                            <input type="text" id="card-expiry" name="card-expiry" placeholder="MM/AA" required>
                        </div>
                        <div class="form-group">
                            <label for="card-cvv">CVV</label>
                            <input type="text" id="card-cvv" name="card-cvv" placeholder="123" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="card-holder-name">Nome do Titular</label>
                        <input type="text" id="card-holder-name" name="card-holder-name" placeholder="Nome como está no cartão" required>
                    </div>
                    <div class="form-group">
                        <label>Bandeira</label>
                        <div class="brand-selector">
                            <button type="button" class="brand-btn" data-brand="visa">
                                <img src="\meuManoBurger\templates\assets\img\Visa.webp" alt="Visa">
                            </button>
                            <button type="button" class="brand-btn" data-brand="mastercard">
                                <img src="\meuManoBurger\templates\assets\img\Mastercard.webp" alt="Mastercard">
                            </button>
                        </div>
                        <input type="hidden" id="card-brand-selected" name="card-brand-selected" value="">
                    </div>
                    <button type="submit" id="modal-submit-btn" class="submit-btn">Salvar Cartão</button>
                </form>
            </div>
        </div>
    </main>
    <div id="modal-confirm-logout" class="modal-overlay">
        <div class="modal-content-small">
            <p>Deseja mesmo sair?</p>
            <div class="modal-buttons">
                <button id="btn-logout-sim" class="btn-confirm-sim">Sim</button>
                <button id="btn-logout-nao" class="btn-confirm-nao">Não</button>
            </div>
        </div>
    </div>

    <script src="/meuManoBurger/templates/assets/js/perfil.js"></script>

</body>
</html>
