<?php
session_start();
header('Content-Type: application/json');

$projectRoot = __DIR__ . '/..';

// Autoload principal
require_once $projectRoot . '/vendor/autoload.php';
require_once $projectRoot . '/Model/Cliente.php';
require_once $projectRoot . '/Controller/ClienteController.php';
require_once __DIR__ . '/../Lib/PixPayloadGenerator.php';

use Model\Cliente;
use Controller\ClienteController;

// BaconQrCode
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

$action = $_GET['action'] ?? ($_POST['action'] ?? null);

// ---------------------- //
//   VERIFICAÇÃO 2FA     //
// ---------------------- //

if ($action === 'verify-login-2fa') {

    if (empty($_SESSION['pending_2fa']) || empty($_SESSION['pending_id_cliente'])) {
        echo json_encode(['success' => false, 'message' => 'Sessão de verificação 2FA não iniciada.']);
        exit;
    }

    $code = $_POST['code'] ?? '';
    $clienteController = new ClienteController();
    $response = $clienteController->verifyLogin2FA($_SESSION['pending_id_cliente'], $code);

    echo json_encode($response);
    exit;
}

// ---------------------- //
//   PROTEÇÃO DE ROTAS   //
// ---------------------- //

if (!isset($_SESSION['id_cliente'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Acesso não autorizado.']);
    exit;
}

$id_cliente = $_SESSION['id_cliente'];
$clienteController = new ClienteController();

// ---------------------- //
//        2FA             //
// ---------------------- //

if ($action === 'generate-2fa') {
    $response = $clienteController->generate2FASecret($id_cliente, $_SESSION['email_cliente']);
    echo json_encode($response);
    exit;
}

if ($action === 'disable-2fa') {
    $password = $_POST['password'] ?? '';
    $response = $clienteController->disable2FA($id_cliente, $password);
    echo json_encode($response);
    exit;
}

if ($action === 'verify-2fa') {
    $secret = $_POST['secret'] ?? '';
    $code = $_POST['code'] ?? '';
    $response = $clienteController->verifyAndEnable2FA($id_cliente, $secret, $code);
    echo json_encode($response);
    exit;
}

// ---------------------- //
//  MENSAGENS DE FLASH    //
// ---------------------- //

if ($action === 'set-flash-message') {
    $type = $_POST['type'] ?? 'error';
    $message = $_POST['message'] ?? 'Ocorreu um erro.';

    if ($type === 'success') {
        $_SESSION['success_message'] = $message;
    } else {
        $_SESSION['error_message'] = $message;
    }

    echo json_encode(['success' => true]);
    exit;
}

// --------------------------------------------- //
//              GERAR QR PIX                     //
// --------------------------------------------- //

if ($action === 'generate_pix_qrcode') {

    if (!class_exists('\Controller\CarrinhoController')) {
        require_once __DIR__ . '/../Controller/CarrinhoController.php';
    }

    try {
        $carrinhoController = new \Controller\CarrinhoController();
        $totalPedido = $carrinhoController->getCartTotal($_SESSION['id_cliente']);

        $admModel = new \Model\Adm();
        $admInfo = $admModel->getAdmByEmail('administrador1@gmail.com');

        if ($totalPedido <= 0) {
            echo json_encode(['success' => false, 'message' => 'Seu carrinho está vazio.']);
            exit;
        }

        if (empty($admInfo['chave_pix'])) {
            echo json_encode(['success' => false, 'message' => 'A chave Pix da loja não foi configurada.']);
            exit;
        }

        // 1. Pega a chave do banco de dados.
        $chavePixComMascara = $admInfo['chave_pix'];

        // 2. Remove TUDO que não for número. Isso é mais agressivo e garantido para CPF/CNPJ.
        $chavePixLimpa = preg_replace('/\D/', '', $chavePixComMascara);


        // Montar Payload PIX
        $pixGenerator = new \Lib\PixPayloadGenerator();
        $pixGenerator
            ->setChavePix($admInfo['chave_pix'])
            ->setNomeRecebedor('MeuManoBurger')
            ->setCidadeRecebedor('CAMACARI')
            ->setValor($totalPedido)
            ->setTxid('MMB' . $_SESSION['id_cliente'] . time());

        $payload = $pixGenerator->getPayload();

        // ----------- GERAR QR EM SVG (NÃO REQUER IMAGICK!) ----------- //

        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);

        // Gera SVG puro
        $svg = $writer->writeString($payload);

        // Converte para Base64
        $qrBase64 = base64_encode($svg);
        $qrDataUrl = 'data:image/svg+xml;base64,' . $qrBase64;

        echo json_encode([
            'success' => true,
            'payload' => $payload,
            'qrCodeUrl' => $qrDataUrl
        ]);
        exit;

    } catch (\Throwable $e) {

        http_response_code(500);
        error_log('generate_pix_qrcode error: ' . $e->getMessage());

        echo json_encode([
            'success' => false,
            'message' => 'Erro ao gerar QR Pix: ' . $e->getMessage()
        ]);
        exit;
    }
}

http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Ação inválida.']);
