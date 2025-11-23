<?php
header('Content-Type: application/json');
session_start();

// --- [A CORREÇÃO DEFINITIVA ESTÁ AQUI] ---
// Inclui o autoload do Composer, que carrega todas as bibliotecas externas.
require_once __DIR__ . '/../vendor/autoload.php';

// 1. Bloco de Segurança: Verifica se o administrador está logado.
if (!isset($_SESSION['id_adm']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    http_response_code(403 ); // Código HTTP para "Proibido"
    echo json_encode(['success' => false, 'message' => 'Acesso não autorizado.']);
    exit;
}

// 2. Inclusões de Arquivos Essenciais (APENAS o que for necessário para a ação)
require_once __DIR__ . '/../Model/Connection.php';
require_once __DIR__ . '/../Model/Adm.php';
require_once __DIR__ . '/../Controller/AdmController.php';

// Pega a ação solicitada pela URL
$action = $_GET['action'] ?? null;

// 3. Roteador de Ações
switch ($action) {
    // --- AÇÕES DE AUTENTICAÇÃO 2FA ---
    case 'generate-2fa':
        $admController = new \Controller\AdmController();
        $id_adm = $_SESSION['id_adm'];
        $email_adm = $_SESSION['email_adm'];
        // Agora, esta chamada funcionará porque o autoload foi incluído.
        $response = $admController->generate2FASecret($id_adm, $email_adm);
        echo json_encode($response);
        break;

    case 'verify-2fa':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admController = new \Controller\AdmController();
            $id_adm = $_SESSION['id_adm'];
            $secret = $_POST['secret'] ?? '';
            $code = $_POST['code'] ?? '';
            $response = $admController->verifyAndEnable2FA($id_adm, $secret, $code);
            echo json_encode($response);
        }
        break;

    case 'disable-2fa':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admController = new \Controller\AdmController();
            $id_adm = $_SESSION['id_adm'];
            $password = $_POST['password'] ?? '';
            $response = $admController->disable2FA($id_adm, $password);
            echo json_encode($response);
        }
        break;

    // --- CASO PADRÃO ---
    default:
        http_response_code(400 ); // Código HTTP para "Requisição Inválida"
        echo json_encode(['success' => false, 'message' => 'Ação de API inválida ou não especificada.']);
        break;
}

exit;