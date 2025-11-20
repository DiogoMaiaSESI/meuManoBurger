<?php
// Define o tipo de conteúdo da resposta como JSON para todas as respostas.
header('Content-Type: application/json');
session_start();

// 1. Bloco de Segurança: Verifica se o administrador está logado.
if (!isset($_SESSION['id_adm']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    http_response_code(403 ); // Código HTTP para "Proibido"
    echo json_encode(['success' => false, 'message' => 'Acesso não autorizado.']);
    exit;
}

// 2. Inclusões de Arquivos Essenciais
// O autoload do Composer deve ser o primeiro, se você o usa.
// require_once __DIR__ . '/../vendor/autoload.php'; 
require_once __DIR__ . '/../Model/Connection.php'; // Essencial para os Models
require_once __DIR__ . '/../Model/Adm.php';
require_once __DIR__ . '/../Controller/AdmController.php';
require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../Model/Estoque.php';
require_once __DIR__ . '/../Controller/ProductController.php';

// Pega a ação solicitada pela URL (ex: ?action=update_product)
$action = $_GET['action'] ?? null;

// 3. Roteador de Ações
switch ($action) {
    // --- AÇÕES DE PRODUTO ---
    case 'update_product':
    case 'delete_product':
        // Instancia os models e o controller CORRETAMENTE
        $productModel = new \Model\Product();
        $estoqueModel = new \Model\Estoque();
        $productController = new \Controller\ProductController($productModel, $estoqueModel);

        if ($action === 'update_product' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Chama o método SEM argumentos. O método já sabe ler $_POST e $_FILES.
            $response = $productController->update();
            echo json_encode($response);
        } elseif ($action === 'delete_product' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Chama o método SEM argumentos. O método já sabe ler o corpo da requisição.
            $response = $productController->delete();
            echo json_encode($response);
        }
        break;

    // --- AÇÕES DE AUTENTICAÇÃO 2FA ---
    case 'generate-2fa':
    case 'verify-2fa':
    case 'disable-2fa':
        // Instancia os models e o controller de ADM
        $admModel = new \Model\Adm();
        $admController = new \Controller\AdmController(); // Supondo que o construtor precise do model
        $id_adm = $_SESSION['id_adm'];

        if ($action === 'generate-2fa') {
            $response = $admController->generate2FASecret($id_adm, $_SESSION['email_adm']);
            echo json_encode($response);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'verify-2fa') {
            $secret = $_POST['secret'] ?? '';
            $code = $_POST['code'] ?? '';
            $response = $admController->verifyAndEnable2FA($id_adm, $secret, $code);
            echo json_encode($response);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'disable-2fa') {
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

exit; // Garante que o script termine aqui.
