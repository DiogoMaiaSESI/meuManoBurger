<?php

use Controller\AdmController;
session_start();

require_once __DIR__ . '/../Controller/ClienteController.php';
require_once __DIR__ . '/../Controller/AdmController.php';
require_once __DIR__ . '/../Model/Cliente.php';

$errorMessage = $_SESSION['error_message'] ?? null;
unset($_SESSION['error_message']);

$show2FAModal = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $senha = $_POST['password'] ?? null;

    if (empty($email) || empty($senha)) {
        $_SESSION['error_message'] = "E-mail e senha são obrigatórios.";
        header('Location: login.php');
        exit;
    }

    // --- CAMINHO DO ADMINISTRADOR ---
    if ($email === 'administrador1@gmail.com' || $email === 'administrador2@gmail.com' || $email === 'administrador3@gmail.com') {
        $admModel = new \Model\Adm();
        $admController = new AdmController();
        $admin = $admController->login($email, $senha);

        if ($admin) {
            if ($admin['2fa_enabled']) {
                // Precisa de 2FA, prepara a sessão e o modal.
                $_SESSION['pending_2fa_adm'] = true;
                $_SESSION['pending_id_adm'] = $admin['id_adm'];
                $show2FAModal = true; 
                // O script continua para renderizar o HTML com o modal ativo.
            } else {
                // Login de ADM sem 2FA, cria a sessão e redireciona.
                $_SESSION['id_adm'] = $admin['id_adm'];
                $_SESSION['nome_adm'] = $admin['nome_adm'];
                $_SESSION['email_adm'] = $admin['email_adm'];
                $_SESSION['is_admin'] = true;
                header('Location: perfil_Adm.php');
                exit;
            }
        } else {
            // Credenciais de ADM inválidas.
            $_SESSION['error_message'] = "Credenciais de administrador inválidas.";
            header('Location: login.php');
            exit;
        }
    
    // --- CAMINHO DO CLIENTE ---
    } else { 
        // Se o e-mail NÃO é de administrador, então tenta como cliente.
        $clienteModel = new \Model\Cliente();
        $clienteController = new \Controller\ClienteController($clienteModel);
        $result = $clienteController->login($email, $senha);

        if ($result === '2fa_required') {
            // Cliente precisa de 2FA.
            $show2FAModal = true;
        } elseif ($result === true) {
            // Login de cliente normal bem-sucedido.
            
            header('Location: paginaPrincipalUser.php');
            exit;
        } else {
            // E-mail e senha não correspondem a ADM nem a Cliente.
            $_SESSION['error_message'] = "E-mail ou senha inválidos.";
            header('Location: login.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../templates/assets/css/login.css">
    <link rel="icon" href="../templates/assets/img/Logo.png">
    <title>Login | MeuManoBurger</title>

    <style>
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            width: 42.0rem;
            max-width: 100%;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .modal h2 {
            margin: 0 0 0.5rem 0;
        }

        .modal .error {
            color: #b00020;
            margin-top: 0.5rem;
        }

        .modal .actions {
            margin-top: 1rem;
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .modal input[type="text"] {
            width: 100%;
            padding: 0.6rem;
            font-size: 1.1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .btn-primary {
            background: #8b1f23;
            color: #fff;
            padding: 0.6rem 1rem;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
            width: 15.0rem;
            margin-left: 5.0rem;
            font-size: 1.2rem;
        }

        .btn-secondary {
            background: #eee;
            color: #333;
            padding: 0.5rem 0.8rem;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <main>
        <div class="container">
            <div class="imagem_login">
                <img src="../templates/assets/img/imglogin-cadastro.png" alt="Uma mulher sentada...">
            </div>

            <div class="form_login">
                <h1>Seja Bem-Vindo ao MeuManoBurger</h1>
                <h2>Realize o Login</h2>

                <form method="POST" action="login.php" id="login-form">
                    <div class="inputs">
                        <p>Email</p>
                        <input type="email" name="email" id="email" required>
                        <p class="msg_erro">Este campo é obrigatório</p>

                        <p>Senha</p>
                        <input type="password" name="password" id="password" required>
                        <p class="msg_erro">Este campo é obrigatório</p>
                    </div>

                    <?php if ($errorMessage): ?>
                        <div class="login-error-message">
                            <?php echo htmlspecialchars($errorMessage); ?>
                        </div>
                    <?php endif; ?>
                    <div class="btn_entrar">
                        <button type="submit">Entrar</button>
                    </div>
                </form>

                <p class="cadastre-se">Não tem uma conta? <span>Cadastre-se</span></p>
                <footer></footer>
            </div>
        </div>
    </main>

    <!-- 2FA Modal -->
    <div id="modal-2fa" class="modal-overlay <?php echo $show2FAModal ? 'active' : ''; ?>"
        aria-hidden="<?php echo $show2FAModal ? 'false' : 'true'; ?>">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-2fa-title">
            <h2 id="modal-2fa-title">Verificação em 2 Etapas</h2>
            <p>Digite o código do seu aplicativo autenticador (6 dígitos).</p>

            <input id="twofa-code" type="text" inputmode="numeric" pattern="\d{6}" maxlength="6" placeholder="123456"
                autocomplete="one-time-code">

            <div class="error" id="twofa-error" style="display:none;"></div>

            <div class="actions">
                <button id="twofa-cancel" class="btn-secondary">Cancelar</button>
                <button id="twofa-submit" class="btn-primary">Verificar e entrar</button>
            </div>
        </div>
    </div>

    <script src="../templates/assets/js/login.js"></script>
</body>

</html>