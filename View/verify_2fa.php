<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../Controller/ClienteController.php';
require_once __DIR__ . '/../Model/Cliente.php';

// Verifica se o fluxo 2FA foi iniciado
if (empty($_SESSION['pending_2fa']) || empty($_SESSION['pending_id_cliente'])) {
    echo json_encode(['success' => false, 'message' => 'Fluxo de 2FA não iniciado. Faça login primeiro.']);
    exit;
}

$code = $_POST['code'] ?? null;
if (!$code) {
    echo json_encode(['success' => false, 'message' => 'Código não informado.']);
    exit;
}

$clienteModel = new \Model\Cliente();
$clienteController = new \Controller\ClienteController($clienteModel);

// espera-se que verifyLogin2FA retorne ['success'=>bool,'message'=>string?]
// e que, em caso de sucesso, a sessão do usuário seja completada dentro do controller
$response = $clienteController->verifyLogin2FA($_SESSION['pending_id_cliente'], $code);

echo json_encode($response);
exit;
?>