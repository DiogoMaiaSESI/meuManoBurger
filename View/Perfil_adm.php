<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Administrador - Meu Mano Burger</title>
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/Perfil.css">
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/Seguranca.css">

     <style>
        .sandwich-menu-container {
            position: absolute;
            top: 10.8rem;
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
    <header class="main-header">
        <div class="header-content">
            <div class="header-left">
                <button id="sandwich-menu-btn" class="menu-btn">
                    <figure><img src="/meuManoBurger/templates/assets/img/Menu.png" alt="Menu" class="icon-img">
                    </figure>
                </button>
            </div>
            <div class="header-center">
                <figure class="logo-container"><img src="/meuManoBurger/templates/assets/img/Logo.png"
                        alt="Logo Meu Mano Burger" class="logo-principal"></figure>
            </div>
            <nav class="header-right">
                <a href="#" class="icon-link">
                    <figure><img src="/meuManoBurger/templates/assets/img/Voltar.png" alt="Voltar" class="icon-img">
                    </figure>
                </a>
                <a href="#" class="icon-link">
                    <figure><img src="/meuManoBurger/templates/assets/img/Carrinho.png" alt="Carrinho" class="icon-img">
                    </figure>
                </a>
                <a href="#" class="icon-link">
                    <figure><img src="/meuManoBurger/templates/assets/img/MiniPerfil.png" alt="Perfil" class="icon-img">
                    </figure>
                </a>
            </nav>
        </div>
    </header>

    <main id="profile-container" class="profile-container">

        <aside class="sidebar">
            <div class="sidebar-header">
                <p>Olá, Biatriz!</p>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#" id="btn-dados" class="nav-link active">Meus dados</a></li>
                    <li><a href="#" id="btn-historico" class="nav-link">Histórico de Pedidos</a></li>
                    <li><a href="#" id="btn-seguranca" class="nav-link">Segurança</a></li>
                    <li><a href="#" id="btn-sair" class="nav-link">Sair da Conta</a></li>
                </ul>
            </nav>
        </aside>

        <section class="content-area">

            <div id="content-dados" class="content-tab active">
                <div class="form-card">
                    <div class="form-top-section">
                        <div class="form-header">
                            <h2>Meus Dados</h2>
                        </div>
                        <div class="profile-picture-container">
                            <figure>
                                <img src="/meuManoBurger/templates/assets/img/FotoPerfil.png" alt="Foto de Perfil"
                                    id="profile-pic-preview" class="profile-picture">
                            </figure>
                            <input type="file" id="file-upload-input" accept="image/png, image/jpeg, image/webp"
                                style="display: none;">
                            <button type="button" id="edit-pic-btn" class="edit-picture-btn">
                                <figure><img src="/meuManoBurger/templates/assets/img/Edicao.png" alt="Editar Foto"
                                        class="icon-img icon-editar"></figure>
                            </button>
                            <div id="pic-action-buttons" class="pic-action-buttons">
                                <button id="save-pic-btn" class="btn-save-pic">Salvar</button>
                                <button id="cancel-pic-btn" class="btn-cancel-pic">Cancelar</button>
                            </div>
                        </div>
                    </div>
                    <form id="profile-form" class="profile-form" method="POST" action="">
                        <div class="form-group"><label for="nome">Nome</label><input type="text" id="nome" name="nome"
                                value="Biatriz Washington Stalingrado Lisboa Londres"></div>
                        <div class="form-group"><label for="email">Email</label><input type="email" id="email"
                                name="email" value="Biatriz@gmail.com"></div>
                        <button type="submit" class="submit-btn">Salvar Alterações</button>
                    </form>
                </div>
            </div>

            <div id="content-seguranca" class="content-tab">
                <div class="form-card">
                    <div class="form-header">
                        <h2>Segurança</h2>
                    </div>
                    <div class="security-section">
                        <h3>Autenticação de 2 Fatores (2FA)</h3>
                        <a href="#" class="add-2fa-link">+ Adicionar método de autenticação</a>
                    </div>
                    <form id="security-form" class="security-form" method="POST" action="">
                        <h3>Alterar senha</h3>
                        <div class="form-group password-group">
                            <input type="password" id="nova-senha" name="nova-senha" placeholder="Nova senha">
                            <img src="/meuManoBurger/templates/assets/img/olhofechado.png" class="password-toggle-icon"
                                alt="Mostrar/Ocultar Senha">
                        </div>
                        <div class="form-group password-group">
                            <input type="password" id="confirmar-senha" name="confirmar-senha"
                                placeholder="Confirmação de nova senha">
                            <img src="/meuManoBurger/templates/assets/img/olhofechado.png" class="password-toggle-icon"
                                alt="Mostrar/Ocultar Senha">
                        </div>
                        <button type="submit" id="btn-salvar-senha" class="submit-btn">Salvar Alterações</button>
                        <div id="password-error-message" class="error-message"></div>
                    </form>
                </div>
            </div>

        </section>

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

    <script src="/meuManoBurger/templates/assets/js/Perfil_adm.js"></script>

</body>

</html>