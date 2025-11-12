<?php
session_start();

// --- 1. INCLUSÕES E INSTÂNCIAS ---
require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../Model/Estoque.php';
require_once __DIR__ . '/../Controller/ProductController.php';
require_once __DIR__ . '/../Controller/EstoqueController.php';

$productModel = new \Model\Product();
$estoqueModel = new \Model\Estoque();
$productController = new \Controller\ProductController($productModel, $estoqueModel);
$estoqueController = new \Controller\EstoqueController();

// --- 2. LÓGICA PARA BUSCAR O PRODUTO ---
$productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$productId) {
    die('Erro: ID do produto não fornecido ou inválido.');
}

$product = $productController->findById($productId);
$stock = $estoqueController->obtEstoque($productId);

if (!$product) {
    die('Erro: Produto não encontrado.');
}

// --- 3. PREPARAÇÃO DAS VARIÁVEIS PARA O HTML ---
$nomeProduto = htmlspecialchars($product['nome_produto']);
$descricaoProduto = htmlspecialchars($product['descricao_produto']);
$precoProduto = 'R$ ' . number_format($product['preco_produto'], 2, ',', '.');
$tipoProduto = htmlspecialchars($product['tipo_produto']);
$quantidadeEstoque = $stock ? $stock['qtd_produto'] : 0;
$imagemProduto = 'data:image/jpeg;base64,' . base64_encode($product['imagem_produto']);

// Opcional: Verificar se o cliente está logado para funcionalidades como "favoritar"
$isClienteLoggedIn = isset($_SESSION['id_cliente']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes: <?php echo $nomeProduto; ?> | MeuManoBurger</title>
    <!-- Use o CSS do usuário aqui, se for diferente -->
    <link rel="stylesheet" href="../templates/assets/css/detalhamentoUser.css" type="text/css"> 
</head>
<body>
    <header>
        <!-- Seu código do header -->
    </header>

    <main>
        <div class="container">
            <div class="mainDiv">
                <div class="leftDiv">
                    <figure>
                        <img src="<?php echo $imagemProduto; ?>" alt="Foto de <?php echo $nomeProduto; ?>">
                    </figure>
                </div>
                <div class="rightDiv">
                    <div class="title">
                        <h2 class="title"><?php echo $nomeProduto; ?></h2>
                        <!-- Ícones de ADM são omitidos aqui -->
                    </div>
                    <p><?php echo $descricaoProduto; ?></p>
                    <h2 class="price"><?php echo $precoProduto; ?></h2>
                    <button class="add-to-cart-btn">Adicionar ao Carrinho</button>
                </div>
            </div>
            <div class="secondDiv">
                <div><h4 class="subtitle">Tipo</h4><h4 class="subtitle2"><?php echo $tipoProduto; ?></h4></div>
                <!-- A quantidade em estoque pode ser omitida para o cliente, se preferir -->
                <!-- <div><h4 class="subtitle">Quantidade</h4><h4 class="subtitle2"><?php echo $quantidadeEstoque; ?></h4></div> -->
            </div>
        </div>
    </main>
    <script src="../templates/assets/js/detalhamentoUser.js"></script>
</body>
</html>
