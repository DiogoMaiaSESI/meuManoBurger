<?php
session_start();

require_once __DIR__ . '/../Controller/ClienteController.php';
require_once __DIR__ . '/../Model/Cliente.php';

// --- LÓGICA DE PROCESSAMENTO DO LOGIN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = $_POST['email'] ?? null;
    $senha = $_POST['password'] ?? null;

    if (empty($email) || empty($senha)) {
        $_SESSION['error_message'] = "E-mail e senha são obrigatórios.";
        header('Location: login.php');
        exit;
    }

    $clienteModel = new \Model\Cliente();
    $clienteController = new \Controller\ClienteController($clienteModel);

    if ($clienteController->login($email, $senha)) {
        unset($_SESSION['error_message']);
        header('Location: Perfil.php');
        exit;
    } else {
        $_SESSION['error_message'] = "E-mail ou senha inválidos. Verifique seus dados ou cadastre-se.";
        header('Location: login.php');
        exit;
    }
}

$errorMessage = $_SESSION['error_message'] ?? null;
unset($_SESSION['error_message']);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../templates/assets/css/login.css">
    <link rel="icon" href="../templates/assets/img/Logo.png">
    <title>Login | MeuManoBurger</title>
</head>
<body>
    <main>
        <div class="container">
            <div class="imagem_login">
                
                    <img src="../templates/assets/img/imglogin-cadastro.png" alt="Uma mulher sentada em uma cadeira com um notebook no colo, com um celular na página de login atrás">
            </div>

            <div class="form_login">
                <h1>Seja Bem-Vindo ao MeuManoBurger</h1>
                <h2>Realize o Login</h2>
            
                <form method="POST" action="login.php">
                    <div class="inputs">
                        <p>Email</p>
                        <input type="email" name="email" id="email">
                        <p class="msg_erro">Este campo é obrigatório</p>
                        
                        <p>Senha</p>
                        <input type="password" name="password" id="password">
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

    <script src="../templates/assets/js/login.js"></script>
</body>
</html>