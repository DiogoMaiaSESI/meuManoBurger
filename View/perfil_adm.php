<?php
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];
require_once "$root/vendor/autoload.php";
require_once "$root/Controller/AdmController.php";
require_once "$root/Model/Adm.php";
function isAdmLoggedIn()
{
    return isset($_SESSION['id_adm']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

if($_SESSION['id_adm'] !== null) {
    $idAdm = $_SESSION['id_adm'];
} else {
    header('Location: login.php');
}
$idAdm = $_SESSION['id_adm'];
$admModel = new \Model\Adm();
$admController = new \Controller\AdmController();


if (!isAdmLoggedIn()) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit; // Para a execução aqui. Nada abaixo será processado.
}

$admModel = new \Model\Adm();
$admController = new \Controller\AdmController();

$imagem_adm = $admController->getAdmById($idAdm)['imagem_adm'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'update_profile') {
        $admController->updateAdm(
            $_SESSION['id_adm'],
            $_POST['nome'] ?? null,
            $_POST['email'] ?? null,
            $_FILES['imagem_adm'] ?? null // O controller vai lidar com o arquivo
        );
    }

    if (isset($_POST['action']) && $_POST['action'] === 'update_password') {
        $admController->updatePassword(
            $_SESSION['id_adm'],
            $_POST['nova_senha'] ?? null,
            $_POST['confirmar_senha'] ?? null
        );
    }
}

$nomeAdm = $_SESSION['nome_adm'] ?? 'Admin';
$emailAdm = $_SESSION['email_adm'] ?? 'admin@exemplo.com';

$imagemAdm = '/templates/assets/img/perfil.png'; // Imagem padrão
if (isset($_SESSION['imagem_adm']) && !empty($_SESSION['imagem_adm'])) {
    $imagemAdm = 'data:image/jpeg;base64,' . base64_encode($_SESSION['imagem_adm']);
}

$adm2FAData = $admModel->get2FAData($_SESSION['id_adm']);
$is2FAEnabled = ($adm2FAData && $adm2FAData['2fa_enabled'] == 1);

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Limpa todas as variáveis da sessão.
    $_SESSION = array();

    // Destrói o cookie de sessão no navegador.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Finalmente, destrói a sessão no servidor.
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
    <link rel="stylesheet" href="/templates/assets/css/perfil.css">
    <link rel="stylesheet" href="/templates/assets/css/seguranca.css">
    <link rel="stylesheet" href="/templates/assets/css/modalPagamento.css">

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

        .unified-nav ul {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0;
            gap: 5.0rem;
            list-style: none;
        }
    </style>
</head>

<body>
    <div class="sandwich-menu-container">
        <div class="options">
            <div class="option">
                <figure><img src="/templates/assets/img/Cardapio.png" alt="Cardápio"></figure>
                <h5>Cardápio</h5>
            </div>
            <div class="option">
                <figure><img src="/templates/assets/img/Pedidos.png" alt="Pedidos"></figure>
                <h5>Pedidos</h5>
            </div>
            <div class="option">
                <figure><img src="/templates/assets/img/Feedbacks.png" alt="Feedbacks"></figure>
                <h5>Feedbacks</h5>
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
                        <figure><img src="/templates/assets/img/Menu.png" alt="Menu" class="icon-img">
                        </figure>
                    </button>
                </li>

                <!-- Logo (Apenas Desktop) -->
                <li class="desktop-only">
                    <figure class="logo-container">
                        <img src="/templates/assets/img/Logo.png" alt="Logo Meu Mano Burger"
                            class="logo-principal">
                    </figure>
                </li>

                <!-- Links de Perfil (Tablet/Mobile) -->
                <li class="mobile-only"><a href="#" id="m-btn-dados" class="nav-link active hide-on-desktop">Meus
                        dados</a></li>
                <li class="mobile-only"><a href="#" id="m-btn-historico" class="nav-link hide-on-desktop">Histórico</a>
                </li>
                <li class="mobile-only"><a href="#" id="m-btn-seguranca" class="nav-link hide-on-desktop">Segurança</a>
                </li>
                <li class="mobile-only"><a href="#" id="m-btn-sair" class="nav-link hide-on-desktop">Sair</a></li>

                <!-- Ícones de Ação (Sempre visíveis, no final) -->
                <li class="nav-right">
                    <a href="empresa.php" class="icon-link">
                        <figure><img src="/templates/assets/img/Voltar.png" alt="Voltar" class="icon-img">
                        </figure>
                    </a>
                    <a href="#" class="icon-link">
                        <figure class="perfilFigure"><img class="profileButton" src="data:image/jpeg;base64,<?php echo base64_encode($imagem_adm);?>" alt="Perfil"
                                class="icon-img"></figure>
                    </a>
                </li>
            </ul>
        </nav>
    </header>



    <main id="profile-container" class="profile-container">

        <aside class="sidebar">
            <div class="sidebar-header">
                <p>Olá, <?php echo htmlspecialchars($_SESSION['nome_adm']); ?>!</p>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#" id="btn-dados" class="nav-link active">Meus dados</a></li>
                    <li><a href="pedidosADM.php" id="btn-historico" class="nav-link">Histórico de Pedidos</a></li>
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
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($imagem_adm);?>" alt="Foto de Perfil" id="profile-pic-preview"
                                    class="profile-picture">
                            </figure>

                            <!-- O input de arquivo, escondido -->
                            <input type="file" id="file-upload-input" accept="image/png, image/jpeg, image/webp"
                                style="display: none;">

                            <!-- O botão de edição que aciona o input -->
                            <button type="button" id="edit-pic-btn" class="edit-picture-btn">
                                <figure><img src="/templates/assets/img/Edicao.png" alt="Editar Foto"
                                        class="icon-img icon-editar"></figure>
                            </button>

                            <!-- Botões de Salvar/Cancelar, escondidos inicialmente -->
                            <div id="pic-action-buttons" class="pic-action-buttons">
                                <button id="save-pic-btn" class="btn-save-pic">Salvar</button>
                                <button id="cancel-pic-btn" class="btn-cancel-pic">Cancelar</button>
                            </div>
                        </div>
                    </div>
                    <form id="profile-form" class="profile-form" method="POST" action="perfil_adm.php"
                        enctype="multipart/form-data">
                        <input type="hidden" name="action" value="update_profile">
                        <input type="file" name="imagem_adm" id="file-upload-input" accept="image/*"
                            style="display: none;">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome"
                                value="<?php echo htmlspecialchars($_SESSION['nome_adm']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email"
                                value="<?php echo htmlspecialchars($_SESSION['email_adm']); ?>">
                        </div>
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
                        <?php if ($is2FAEnabled): ?>
                            <div class="status-2fa active">
                                <span>Status: Ativada</span>
                                <button id="btn-open-disable-2fa" class="disable-2fa-btn">Desativar</button>
                            </div>
                        <?php else: ?>
                            <a href="#" class="add-2fa-link">+ Adicionar método de autenticação</a>
                        <?php endif; ?>
                    </div>

                    <form id="security-form" class="security-form" method="POST" action="perfil_adm.php">
                        <input type="hidden" name="action" value="update_password">

                        <h3>Alterar senha</h3>
                        <div class="form-group password-group">
                            <input type="password" id="nova-senha" name="nova_senha" placeholder="Nova senha" required>
                            <img src="/templates/assets/img/olhofechado.png" class="password-toggle-icon"
                                alt="Mostrar/Ocultar Senha">
                        </div>
                        <div class="form-group password-group">
                            <input type="password" id="confirmar-senha" name="confirmar_senha"
                                placeholder="Confirmação de nova senha" required>
                            <img src="/templates/assets/img/olhofechado.png" class="password-toggle-icon"
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
    <!-- MODAL PARA DESATIVAR 2FA -->
    <div id="modal-disable-2fa" class="modal-overlay">
        <div class="modal-content">
            <button id="close-disable-2fa-modal-btn" class="close-modal-btn">&times;</button>
            <h2>Desativar Autenticação de 2 Fatores</h2>
            <p style="font-size: 1.5rem;">Para sua segurança, por favor, digite sua senha atual para confirmar a
                desativação.</p>
            <form id="disable-2fa-form">
                <div class="form-group password-group">
                    <input type="password" id="disable-2fa-password" placeholder="Sua senha atual" required>
                    <img src="/templates/assets/img/olhofechado.png" class="password-toggle-icon"
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


    <div id="notification-container" class="notification-container"></div>
    <script src="/templates/assets/js/perfil_adm.js"></script>
    <?php
    if (isset($_SESSION['success_message']) || isset($_SESSION['error_message'])) {
        $message = $_SESSION['success_message'] ?? $_SESSION['error_message'];
        $type = isset($_SESSION['success_message']) ? 'success' : 'error';
        unset($_SESSION['success_message'], $_SESSION['error_message']);
        echo "<script>document.addEventListener('DOMContentLoaded', function() {
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
            });</script>";
    }
    ?>
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