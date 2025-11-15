<?php
session_start();

// Inclui os arquivos necessários
require_once __DIR__ . '/../Controller/ClienteController.php';
require_once __DIR__ . '/../Model/Cliente.php';

// Bloco de processamento: só executa se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    
    // Pega os dados do formulário com os nomes do seu HTML
    $nome = $_POST['nome'] ?? null;
    $email = $_POST['email'] ?? null;
    $senha = $_POST['password'] ?? null;

    // Processa a imagem
    $imagem = null;
    if (isset($_FILES['imagemPerfil']) && $_FILES['imagemPerfil']['error'] === UPLOAD_ERR_OK) {
        $imagem = file_get_contents($_FILES['imagemPerfil']['tmp_name']);
    } else {
        $caminhoImagemPadrao = __DIR__ . '/../templates/assets/img/perfil.png';
        if (file_exists($caminhoImagemPadrao)) {
            $imagem = file_get_contents($caminhoImagemPadrao);
        }
    }

    // Validação
    if (empty($nome) || empty($email) || empty($senha) || empty($imagem)) {
        $_SESSION['error_message'] = "Todos os campos são obrigatórios.";
        header('Location: cadastro.php');
        exit;
    }

    // Usa o Controller para criar o cliente
    $clienteModel = new \Model\Cliente();
    $clienteController = new \Controller\ClienteController();
    if (!$clienteController->checkClienteByEmail($email)) {
        $success = $clienteController->createCliente($nome, $email, $senha, $imagem);
        if ($success) {
            $_SESSION['success_message'] = "Login realizado com sucesso!";
            header('Location: Login.php');
            exit;
        } else {
            $_SESSION['error_message'] = "Erro ao cadastrar. O e-mail já está em uso.";
            header('Location: cadastro.php');
            exit;
        }
    } else {
        echo '<script>alert("Usuário já cadastrado, tente fazer login.")</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../templates/assets/css/cadastro.css">
    <link rel="icon" href="../templates/assets/img/Logo.png">
    <title>Cadastro | MeuManoBurger</title>
</head>

<body>
    <main>
        <div class="container">
            <div class="imagem_login">
                <img src="../templates/assets/img/imglogin-cadastro.png"
                    alt="Uma mulher sentada em uma cadeira com um notebook no colo, com um celular na página de login atrás">
            </div>
            <div class="formContainer">
                <div class="form_cadastro">
                    <h1>Seja Bem-Vindo ao MeumanoBurger</h1>
                    <h2>Cadastre-se</h2>
                    <p class="frase">E aproveite nossos recursos</p>
                    <form method="POST" action="cadastro.php" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="register">
                        <div class="inputs">
                            <div class="foto">
                                <label for="imagemPerfil">
                                    <p class="adfoto"> Adicionar Foto</p>
                                    <figure class="foto-do-perfil">
                                        <img id="previewImagem" src="../templates/assets/img/perfil.png"
                                            alt="Imagem do perfil" />
                                    </figure>
                                </label>
                                <input type="file" id="imagemPerfil" name="imagemPerfil" accept="image/*"
                                    style="display: none;">
                            </div>
                        </div>
    
                        <p class="labelInput">Nome</p>
                        <input type="text" name="nome" id="nome" required>
    
                        <p class="labelInput">Email</p>
                        <input type="email" name="email" id="email" required>
    
                        <p class="labelInput">Senha</p>
                        <input type="password" name="password" id="password" required>
    
                        <p class="labelInput">Confirmar Senha</p>
                        <input type="password" name="confirm_password" id="confirm_password" required>
                        <p class="msg_erro">As senhas não coincidem</p>
    
                        <button type="submit">Cadastrar</button>
                        <p class="login">Já tem uma conta? <span class="login-link">Login</span></p>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </main>
    <script src="../templates/assets/js/cadastro.js"></script>
</body>

</html>