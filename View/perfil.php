<?php
session_start();

require_once __DIR__ . '/../Controller/ClienteController.php';
require_once __DIR__ . '/../Model/Cliente.php';

$clienteModel = new \Model\Cliente();
$clienteController = new \Controller\ClienteController($clienteModel);

// --- LÓGICA DE ATUALIZAÇÃO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $nome = $_POST['nome'] ?? null;
    $email = $_POST['email'] ?? null;
    $id_cliente = $_SESSION['id_cliente'] ?? 0;

    $imagem = null;
    // Verifica se um novo arquivo de imagem foi enviado
    if (isset($_FILES['imagem_cliente']) && $_FILES['imagem_cliente']['error'] === UPLOAD_ERR_OK) {
        $imagem = file_get_contents($_FILES['imagem_cliente']['tmp_name']);
    }

    $success = $clienteController->updateCliente($id_cliente, $nome, $email, $imagem);

    if ($success) {
        $_SESSION['success_message'] = "Perfil atualizado com sucesso!";
    } else {
        $_SESSION['error_message'] = "Erro ao atualizar o perfil.";
    }
    header('Location: perfil.php');
    exit;
}
// --- LÓGICA DE ALTERAÇÃO DE SENHA ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_password') {


    $id_cliente = $_SESSION['id_cliente'] ?? 0;
    $nova_senha = $_POST['nova_senha'] ?? null;
    $confirmar_senha = $_POST['confirmar_senha'] ?? null;

    $success = $clienteController->updatePassword($id_cliente, $nova_senha, $confirmar_senha);

    if ($success) {
        $_SESSION['success_message'] = "Senha alterada com sucesso!";
    } else {
        if (!isset($_SESSION['error_message'])) {
            $_SESSION['error_message'] = "Ocorreu um erro ao alterar a senha.";
        }
    }
    header('Location: perfil.php#content-seguranca');
    exit;
}

// --- LÓGICA DE EXIBIÇÃO ---
// Garante que apenas usuários logados acessem
if (!$clienteController->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Pega os dados da sessão para exibir na página
$nomeUsuario = $_SESSION['nome_cliente'] ?? 'Usuário';
$emailUsuario = $_SESSION['email_cliente'] ?? 'email@exemplo.com';

$imagemUsuario = '../templates/assets/img/FotoPerfil.png'; // Caminho para a imagem padrão (Alanzoka)
if (isset($_SESSION['imagem_cliente']) && !empty($_SESSION['imagem_cliente'])) {
    $imagemUsuario = 'data:image/jpeg;base64,' . base64_encode($_SESSION['imagem_cliente']);
}
$clienteModel = new \Model\Cliente(); // Precisamos de uma instância do model
$cliente2FAData = $clienteModel->get2FAData($_SESSION['id_cliente']);
$is2FAEnabled = ($cliente2FAData && $cliente2FAData['2fa_enabled'] == 1);
// --- LÓGICA DE LOGOUT ---

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
         );
    }

    session_destroy();

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - Meu Mano Burger</title>
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/perfil.css">
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/formasPagamento.css">
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/meusFavoritos.css">
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/seguranca.css">
    <link rel="stylesheet" href="/meuManoBurger/templates/assets/css/modalPagamento.css">

    <style>
        .sandwich-menu-container {
            position: absolute;
            top: 8.3rem;
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
    <div id="notification-container" class="notification-container"></div>
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
        <nav class="unified-nav">
            <ul>
                <!-- Menu Sanduíche (Sempre visível) -->
                <li>
                    <button class="menu-btn sandwich-menu-btn">
                        <figure><img src="/meuManoBurger/templates/assets/img/Menu.png" alt="Menu" class="icon-img">
                        </figure>
                    </button>
                </li>

                <!-- Logo (Apenas Desktop) -->
                <li class="desktop-only">
                    <figure class="logo-container">
                        <img src="/meuManoBurger/templates/assets/img/Logo.png" alt="Logo Meu Mano Burger"
                            class="logo-principal">
                    </figure>
                </li>

                <!-- Links de Perfil (Tablet/Mobile) -->
                <li class="mobile-only"><a href="#" id="m-btn-dados" class="nav-link active hide-on-desktop">Meus
                        dados</a></li>
                <li class="mobile-only"><a href="#" id="m-btn-historico" class="nav-link hide-on-desktop">Histórico</a>
                </li>
                <li class="mobile-only"><a href="#" id="m-btn-favoritos" class="nav-link hide-on-desktop">Favoritos</a>
                </li>
                <li class="mobile-only"><a href="#" id="m-btn-pagamento" class="nav-link hide-on-desktop">Pagamento</a>
                </li>
                <li class="mobile-only"><a href="#" id="m-btn-seguranca" class="nav-link hide-on-desktop">Segurança</a>
                </li>
                <li class="mobile-only"><a href="#" id="m-btn-sair" class="nav-link hide-on-desktop">Sair</a></li>

                <!-- Ícones de Ação (Sempre visíveis, no final) -->
                <li class="nav-right">
                    <a href="paginaPrincipalUser.php" class="icon-link">
                        <figure><img src="/meuManoBurger/templates/assets/img/Voltar.png" alt="Voltar" class="icon-img">
                        </figure>
                    </a>
                    <a href="#" class="icon-link">
                        <figure><img src="/meuManoBurger/templates/assets/img/MiniPerfil.png" alt="Perfil"
                                class="icon-img"></figure>
                    </a>
                </li>
            </ul>
        </nav>
    </header>



    <main id="profile-container" class="profile-container">

        <aside class="sidebar">
            <div class="sidebar-header">
                <p>Olá, <?php echo strtok($nomeUsuario, ' ');?></p>
            </div>
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
                        <div class="form-header">
                            <h2>Meus Dados</h2>
                        </div>
                        <div class="profile-picture-container">
                            <figure>
                                <img src="<?php echo $imagemUsuario; ?>" alt="Foto de Perfil" id="profile-pic-preview"
                                    class="profile-picture">
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
                    <form id="profile-form" class="profile-form" method="POST" action="perfil.php"
                        enctype="multipart/form-data">
                        <input type="hidden" name="action" value="update_profile">

                        <input type="file" id="file-upload-input" name="imagem_cliente" accept="image/*"
                            style="display: none;">

                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome"
                                value="<?php echo htmlspecialchars($nomeUsuario); ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email"
                                value="<?php echo htmlspecialchars($emailUsuario); ?>">
                        </div>
                        <button type="submit" class="submit-btn">Salvar Alterações</button>
                    </form>
                </div>
            </div>
            </div>

            <div id="content-pagamento" class="content-tab">
                <div class="form-card">
                    <div class="form-header">
                        <h2>Formas de Pagamento</h2>
                    </div>
                    <div id="payment-methods-list" class="payment-methods-list"></div>
                    <button type="button" class="add-payment-btn">Adicionar forma de pagamento</button>
                </div>
            </div>

            <div id="content-favoritos" class="content-tab">
                <div class="form-card">
                    <div class="form-header">
                        <h2>Meus Favoritos</h2>
                    </div>
                    <div class="favorites-grid">
                        <div class="favorite-card">
                            <figure><img src="\meuManoBurger\templates\assets\img\Hamburguer.png" alt="Triplo Cheddar">
                            </figure>
                            <h3>Triplo Cheddar</h3>
                            <span class="price">R$ 7,00</span>
                            <button class="details-btn"><img src="/meuManoBurger/templates/assets/img/Carrinho.png"> Ver
                                detalhes</button>
                        </div>
                        <div class="favorite-card">
                            <figure><img src="\meuManoBurger\templates\assets\img\Coxinha.png" alt="Coxinha"></figure>
                            <h3>Coxinha</h3>
                            <span class="price">R$ 7,00</span>
                            <button class="details-btn"><img src="/meuManoBurger/templates/assets/img/Carrinho.png"> Ver
                                detalhes</button>
                        </div>
                        <div class="favorite-card">
                            <figure><img src="\meuManoBurger\templates\assets\img\Pastel.png" alt="Pastel de Carne">
                            </figure>
                            <h3>Pastel de Carne</h3>
                            <span class="price">R$ 7,00</span>
                            <button class="details-btn"><img src="/meuManoBurger/templates/assets/img/Carrinho.png"> Ver
                                detalhes</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="content-seguranca" class="content-tab">
                <div class="form-card">
                    <div class="form-header">
                        <h2>Segurança</h2>
                    </div>
                    <div class="security-section">
                        <h3>Autenticação de 2 Fatores (2FA)</h3>
                        <?php if ($is2FAEnabled): ?>
                            <!-- Se 2FA está ATIVA -->
                            <div class="status-2fa active">
                                <span>Status: Ativada</span>
                                <button id="btn-open-disable-2fa" class="disable-2fa-btn">Desativar</button>
                            </div>
                        <?php else: ?>
                            <!-- Se 2FA está INATIVA -->
                            <a href="#" class="add-2fa-link">+ Adicionar método de autenticação</a>
                        <?php endif; ?>
                    </div>
                    <form id="security-form" class="security-form" method="POST" action="perfil.php">
                        <input type="hidden" name="action" value="update_password">
                        <h3>Alterar senha</h3>
                        <div class="form-group password-group">
                            <input type="password" id="nova-senha" name="nova_senha" placeholder="Nova senha">
                            <img src="/meuManoBurger/templates/assets/img/olhofechado.png" class="password-toggle-icon"
                                alt="Mostrar/Ocultar Senha">
                        </div>
                        <div class="form-group password-group">
                            <input type="password" id="confirmar-senha" name="confirmar_senha"
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

        <div id="modal-add-card" class="modal-overlay">
            <div class="modal-content">
                <button class="close-modal-btn">&times;</button>
                <h2 id="modal-title">Adicionar novo cartão</h2>
                <form id="card-form" method="POST" action="">
                    <div class="form-group">
                        <label for="card-nickname">Nome para o Cartão</label>
                        <input type="text" id="card-nickname" name="card-nickname"
                            placeholder="Ex: Cartão Principal, Cartão da Empresa" required>
                    </div>
                    <div class="form-group">
                        <label for="card-number">Número do Cartão</label>
                        <div class="card-input-wrapper">
                            <input type="text" id="card-number" name="card-number" placeholder="0000 0000 0000 0000"
                                required>
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
                        <input type="text" id="card-holder-name" name="card-holder-name"
                            placeholder="Nome como está no cartão" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo</label>
                        <div class="type-selector">
                            <button type="button" class="type-btn" data-type="credito">Crédito</button>
                            <button type="button" class="type-btn" data-type="debito">Débito</button>
                        </div>
                        <input type="hidden" id="card-type-selected" name="card-type-selected" value="">
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
    <div id="modal-confirm-delete" class="modal-overlay">
        <div class="modal-content-small">
            <p>Deseja mesmo excluir este cartão?</p>
            <div class="modal-buttons">
                <button id="btn-delete-sim" class="btn-confirm-sim">Sim, Excluir</button>
                <button id="btn-delete-nao" class="btn-confirm-nao">Não</button>
            </div>
        </div>
    </div>
    <div id="modal-confirm-logout" class="modal-overlay">
        <div class="modal-content-small">
            <p>Deseja mesmo sair?</p>
            <div class="modal-buttons">
                <button id="btn-logout-sim" class="btn-confirm-sim">Sim</button>
                <button id="btn-logout-nao" class="btn-confirm-nao">Não</button>
            </div>
        </div>
    </div>
    <!-- MODAL PARA DESATIVAR 2FA -->
    <div id="modal-disable-2fa" class="modal-overlay">
        <div class="modal-content">
            <button id="close-disable-2fa-modal-btn" class="close-modal-btn">&times;</button>
            <h2>Desativar Autenticação de 2 Fatores</h2>
            <p style="font-size: 1.5rem;">Para sua segurança, por favor, digite sua senha atual para confirmar a desativação.</p>
            <form id="disable-2fa-form">
                <div class="form-group password-group">
                    <input type="password" id="disable-2fa-password" placeholder="Sua senha atual" required>
                    <img src="/meuManoBurger/templates/assets/img/olhofechado.png" class="password-toggle-icon"
                        alt="Mostrar/Ocultar Senha">
                </div>
                <button type="submit" class="submit-btn danger">Confirmar e Desativar</button>
                <p id="disable-2fa-error-message" class="error-message" style="text-align: center; margin-top: 1rem;">
                </p>
            </form>
        </div>
    </div>
    <!-- MODAL PARA CONFIGURAÇÃO DO 2FA -->
    <div id="modal-2fa" class="modal-overlay">
        <div class="modal-content">
            <button id="close-2fa-modal-btn" class="close-modal-btn">&times;</button>
            <h2>Ativar Autenticação de 2 Fatores</h2>
            <div id="2fa-setup-content">
                <p>1. Escaneie o QR Code abaixo com seu aplicativo autenticador (Google Authenticator, Authy, etc).</p>
                <div id="qr-code-container" class="qr-code-container">
                    <!-- O QR Code será inserido aqui pelo JavaScript -->
                </div>
                <p>2. Digite o código de 6 dígitos gerado pelo aplicativo para verificar.</p>
                <form id="2fa-verify-form">
                    <input type="hidden" id="2fa-secret-input" value="">
                    <div class="form-group">
                        <label for="2fa-code">Código de Verificação</label>
                        <input type="text" id="2fa-code" name="2fa-code" placeholder="123456" required maxlength="6"
                            pattern="\d{6}" inputmode="numeric">
                    </div>
                    <button type="submit" class="submit-btn">Verificar e Ativar</button>
                    <p id="2fa-error-message" class="error-message" style="text-align: center; margin-top: 1rem;"></p>
                </form>
            </div>
        </div>
    </div>


    <script src="/meuManoBurger/templates/assets/js/perfil.js"></script>
    <?php
    // Verifica se existe uma mensagem de sucesso ou erro na sessão
    if (isset($_SESSION['success_message']) || isset($_SESSION['error_message'])) {

        // Define a mensagem e o tipo (classe CSS)
        $message = $_SESSION['success_message'] ?? $_SESSION['error_message'];
        $type = isset($_SESSION['success_message']) ? 'success' : 'error';

        // Limpa as mensagens da sessão para não exibi-las novamente
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);

        // Gera o script JavaScript para criar e exibir a notificação
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('notification-container');
                
                // Cria o elemento da notificação
                const toast = document.createElement('div');
                toast.className = 'toast {$type}';
                toast.textContent = '{$message}';
                
                // Adiciona a notificação ao container
                container.appendChild(toast);
                
                // Força o navegador a aplicar o estilo inicial antes de adicionar a classe 'show'
                setTimeout(() => {
                    toast.classList.add('show');
                }, 10); // Um pequeno delay é suficiente
                
                // Remove a notificação após 5 segundos
                setTimeout(() => {
                    toast.classList.remove('show');
                    // Remove o elemento do DOM após a animação de saída
                    setTimeout(() => {
                        toast.remove();
                    }, 500); // Tempo igual à duração da transição do CSS
                }, 5000);
            });
        </script>
        ";
    }
    ?>

</body>

</html>