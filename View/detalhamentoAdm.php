<?php
session_start();

// --- 1. SEGURANÇA: Garante que apenas o ADM acesse esta página ---
if (!isset($_SESSION['id_adm']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php');
    exit;
}

// --- 2. INCLUSÕES E INSTÂNCIAS ---
require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../Model/Estoque.php';
require_once __DIR__ . '/../Controller/ProductController.php';
require_once __DIR__ . '/../Controller/EstoqueController.php';

$productModel = new \Model\Product();
$estoqueModel = new \Model\Estoque();
$productController = new \Controller\ProductController();
$estoqueController = new \Controller\EstoqueController();

// --- 3. LÓGICA PARA BUSCAR O PRODUTO ---
$productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$productId) {
    die('Erro: ID do produto não fornecido ou inválido.');
}

$product = $productController->findById($productId);
$stock = $estoqueController->obtEstoque($productId);

if (!$product) {
    die('Erro: Produto não encontrado.');
}

// --- 4. PREPARAÇÃO DAS VARIÁVEIS PARA O HTML ---
$nomeProduto = htmlspecialchars($product['nome_produto']);
$descricaoProduto = htmlspecialchars($product['descricao_produto']);
$precoProduto = 'R$ ' . number_format($product['preco_produto'], 2, ',', '.');
$tipoProduto = htmlspecialchars($product['tipo_produto']);
$quantidadeEstoque = $stock ? $stock['qtd_produto'] : 0;
$imagemProduto = 'data:image/jpeg;base64,' . base64_encode($product['imagem_produto']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes: <?php echo $nomeProduto; ?> (Admin) | MeuManoBurger</title>
    <link rel="stylesheet" href="../templates/assets/css/detalhamentoAdm.css" type="text/css">
</head>
<body>
    <!-- Formulário de Edição e Modal de Exclusão (cole o HTML deles aqui) -->
    
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
                        <div class="icons">
                            <figure>
                                <img class="lapis" src="../templates/assets/img/lapis.png" alt="Editar Produto">
                            </figure>
                            <figure>
                                <img class="lixeira" src="../templates/assets/img/lixeira.png" alt="Deletar Produto">
                            </figure>
                        </div>
                    </div>
                    <p><?php echo $descricaoProduto; ?></p>
                    <h2 class="price"><?php echo $precoProduto; ?></h2>
                </div>
            </div>
            <div class="secondDiv">
                <div><h4 class="subtitle">Tipo</h4><h4 class="subtitle2"><?php echo $tipoProduto; ?></h4></div>
                <div><h4 class="subtitle">Quantidade</h4><h4 class="subtitle2"><?php echo $quantidadeEstoque; ?></h4></div>
            </div>
        </div>
    </main>
    <script src="../templates/assets/js/detalhamentoAdm.js"></script>
</body>
</html>
