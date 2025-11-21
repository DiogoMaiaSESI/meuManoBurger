<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Lib/PixPayloadGenerator.php'; // Inclui nossa nova classe

use Controller\CarrinhoController;
use Controller\AdmController;
use Lib\PixPayloadGenerator;

// 1. Garante que o cliente está logado
if (!isset($_SESSION['id_cliente'])) {
    header('Location: login.php');
    exit;
}

// 2. Calcula o valor total do carrinho (lógica similar à da página carrinho.php)
$carrinhoController = new CarrinhoController();
$totalPedido = $carrinhoController->getCartTotal($_SESSION['id_cliente']); // Precisaremos criar este método

if ($totalPedido <= 0) {
    die("Seu carrinho está vazio ou o valor é inválido.");
}

// 3. Busca os dados do ADM (chave pix, nome, cidade)
$admController = new AdmController(new \Model\Adm());
$admInfo = $admController->getAdmData(1); // Supondo que o ID do ADM principal é 1
$chavePix = $admInfo['chave_pix'];
$nomeRecebedor = 'MeuManoBurger'; // Nome da loja
$cidadeRecebedor = 'CAMACARI'; // Cidade da loja

if (empty($chavePix)) {
    die("A loja ainda não configurou uma chave Pix para recebimento.");
}

// 4. Gera um ID de transação único (essencial para a confirmação)
$txid = 'MMB' . $_SESSION['id_cliente'] . time();

// 5. Gera o Payload do Pix
$pixGenerator = new PixPayloadGenerator($chavePix, $nomeRecebedor, $cidadeRecebedor, $totalPedido, $txid);
$payload = $pixGenerator->getPayload();

// 6. Gera a URL da imagem do QR Code usando uma API pública
$qrCodeImageUrl = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . urlencode($payload );
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pagamento via Pix</title>
    <style>
        body { font-family: sans-serif; display: flex; flex-direction: column; align-items: center; padding-top: 40px; }
        .pix-container { text-align: center; border: 1px solid #ccc; padding: 20px; border-radius: 10px; }
        img { width: 300px; height: 300px; }
        .payload-text { word-break: break-all; max-width: 300px; font-size: 12px; background: #eee; padding: 10px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="pix-container">
        <h2>Pague com Pix para finalizar seu pedido!</h2>
        <p>Valor: <strong>R$ <?php echo number_format($totalPedido, 2, ',', '.'); ?></strong></p>
        <img src="<?php echo $qrCodeImageUrl; ?>" alt="QR Code Pix">
        <h3>Pix Copia e Cola:</h3>
        <div class="payload-text"><?php echo $payload; ?></div>
        <p style="margin-top: 20px;">Após o pagamento, seu pedido será confirmado.</p>
    </div>
  <div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
      <div class="vw-plugin-top-wrapper"></div>
    </div>
  </div>
  <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
  <script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
  </script>
</body>
</html>
