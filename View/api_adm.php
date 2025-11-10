<?php
session_start();
header('Content-Type: application/json');

// --- VERIFICAÇÃO DE SEGURANÇA ---
if (!isset($_SESSION['id_adm']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    http_response_code(403 ); // Forbidden
    echo json_encode(['success' => false, 'message' => 'Acesso não autorizado.']);
    exit;
}

// --- INCLUSÕES E CRIAÇÃO DE OBJETOS ---
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Controller/AdmController.php';
require_once __DIR__ . '/../Model/Adm.php';

$admModel = new \Model\Adm();
$admController = new \Controller\AdmController($admModel);

$action = $_GET['action'] ?? null;
$id_adm = $_SESSION['id_adm'];

// --- ROTAS DA API ---
if ($action === 'generate-2fa') {
    $response = $admController->generate2FASecret($id_adm, $_SESSION['email_adm']);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'verify-2fa') {
    $secret = $_POST['secret'] ?? '';
    $code = $_POST['code'] ?? '';
    $response = $admController->verifyAndEnable2FA($id_adm, $secret, $code);
    echo json_encode($response);
    exit;
}

// Se nenhuma ação corresponder
http_response_code(400 );
echo json_encode(['success' => false, 'message' => 'Ação inválida.']);
