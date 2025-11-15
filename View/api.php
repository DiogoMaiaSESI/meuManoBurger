<?php
session_start();
header('Content-Type: application/json');

$projectRoot = __DIR__ . '/..'; 

require_once $projectRoot . '/vendor/autoload.php';
require_once $projectRoot . '/Model/Cliente.php';
require_once $projectRoot . '/Controller/ClienteController.php';

use Model\Cliente;
use Controller\ClienteController;

$action = $_GET['action'] ?? ($_POST['action'] ?? null); // Aceita action via GET ou POST


if ($action === 'verify-login-2fa') {
    if (empty($_SESSION['pending_2fa']) || empty($_SESSION['pending_id_cliente'])) {
        echo json_encode(['success' => false, 'message' => 'Sessão de verificação 2FA não iniciada.']);
        exit;
    }
    $code = $_POST['code'] ?? '';
    $clienteModel = new Cliente();
    $clienteController = new ClienteController($clienteModel);
    $response = $clienteController->verifyLogin2FA($_SESSION['pending_id_cliente'], $code);
    echo json_encode($response);
    exit;
}



if (!isset($_SESSION['id_cliente'])) {
    http_response_code(401 );
    echo json_encode(['success' => false, 'message' => 'Acesso não autorizado.']);
    exit;
}

$id_cliente = $_SESSION['id_cliente'];
$clienteModel = new Cliente();
$clienteController = new ClienteController($clienteModel);

// Rota para gerar o QR Code
if ($action === 'generate-2fa') {
    $response = $clienteController->generate2FASecret($id_cliente, $_SESSION['email_cliente']);
    echo json_encode($response);
    exit;
}
// Rota para DESATIVAR a 2FA
if ($action === 'disable-2fa') {
    $password = $_POST['password'] ?? '';
    $response = $clienteController->disable2FA($id_cliente, $password);
    echo json_encode($response);
    exit;
}
// Rota para ativar a 2FA
if ($action === 'verify-2fa') {
    $secret = $_POST['secret'] ?? '';
    $code = $_POST['code'] ?? '';
    $response = $clienteController->verifyAndEnable2FA($id_cliente, $secret, $code);
    echo json_encode($response);
    exit;
}
if ($action === 'set-flash-message') {
    $type = $_POST['type'] ?? 'error';
    $message = $_POST['message'] ?? 'Ocorreu um erro.';
    
    if ($type === 'success') {
        $_SESSION['success_message'] = $message;
    } else {
        $_SESSION['error_message'] = $message;
    }
    // Apenas confirma que a operação foi feita
    echo json_encode(['success' => true]);
    exit;
}

http_response_code(400 );
echo json_encode(['success' => false, 'message' => 'Ação inválida.']);
?>
