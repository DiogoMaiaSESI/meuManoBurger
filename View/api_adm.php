<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id_adm']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    http_response_code(403 ); // Forbidden
    echo json_encode(['success' => false, 'message' => 'Acesso não autorizado.']);
    exit;
}
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Model/Adm.php';
require_once __DIR__ . '/../Controller/AdmController.php';
require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../Model/Estoque.php';
require_once __DIR__ . '/../Controller/ProductController.php';

$action = $_GET['action'] ?? null;

if ($action === 'update_product' || $action === 'delete_product') {
    $productModel = new \Model\Product();
    $estoqueModel = new \Model\Estoque();
    $productController = new \Controller\ProductController($productModel, $estoqueModel);

    if ($action === 'update_product' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = $productController->update();
        echo json_encode($response);
        exit;
    }

    if ($action === 'delete_product' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = $productController->delete();
        echo json_encode($response);
        exit;
    }
}

if ($action === 'generate-2fa' || $action === 'verify-2fa') {
    $admModel = new \Model\Adm();
    $admController = new \Controller\AdmController($admModel);
    $id_adm = $_SESSION['id_adm'];

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
}

http_response_code(400 );
echo json_encode(['success' => false, 'message' => 'Ação de administrador inválida.']);
