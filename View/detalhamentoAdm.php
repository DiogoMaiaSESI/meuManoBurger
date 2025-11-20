<?php
session_start();

// --- 1. SEGURANÇA: Garante que apenas o ADM acesse esta página ---
if (!isset($_SESSION['id_adm']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php');
    exit;
}

// --- 2. INCLUSÕES E INSTÂNCIAS ---
require_once __DIR__ . '/../Model/Connection.php';
require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../Model/Estoque.php';
require_once __DIR__ . '/../Controller/ProductController.php';
require_once __DIR__ . '/../Controller/EstoqueController.php';

$productModel = new \Model\Product();
$estoqueModel = new \Model\Estoque();
$productController = new \Controller\ProductController($productModel, $estoqueModel);
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

$nomeProduto = htmlspecialchars($product['nome_produto']);
$descricaoProduto = htmlspecialchars($product['descricao_produto']);
$precoProduto = 'R$ ' . number_format($product['preco_produto'], 2, ',', '.');
$tipoProduto = htmlspecialchars($product['tipo_produto']);
$quantidadeEstoque = $stock ? $stock['qtd_produto'] : 0;
$imagemProduto = 'data:image/jpeg;base64,' . base64_encode($product['imagem_produto']);
$urlPerfil = 'login.php'; 
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
    $urlPerfil = 'perfil_adm.php'; // Se for admin, o link aponta para o perfil do admin.
}
// 3. Se não for admin, verificamos se é um cliente.
elseif (isset($_SESSION['id_cliente'])) {
    $urlPerfil = 'Perfil.php'; // Se for cliente, aponta para o perfil do cliente.
}
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
    <form id="edit-product-form" class="modal-form" method="POST" enctype="multipart/form-data">
        <div class="formLeft">
            <h2>Editar lanche</h2>
            <div class="inputs">
                <div class="foto">
                    <h3>Foto</h3>
                    <figure>
                        <!-- o IMG dentro do figure é o que o JS manipula -->
                        <img id="edit-preview-img" src="../templates/assets/img/camera.png" alt="Preview da imagem">
                    </figure>
                    <input type="file" name="imagem_produto" id="edit-foto-input" style="display: none;">
                </div>
                <div class="input">
                    <h4>Nome</h4>
                    <input type="text" id="edit-nome" name="nome_produto" placeholder="Digite o nome do lanche"
                        required>
                </div>
                <div class="input">
                    <h4>Tipo</h4>
                    <select id="edit-tipo" name="tipo_produto" required>
                        <option value="" disabled>Selecione o tipo do lanche</option>
                        <option value="Hamburgueres">Hambúrgueres</option>
                        <option value="Lanches">Lanches</option>
                        <option value="Bebidas">Bebidas</option>
                        <option value="Cafe da manha">Café da manhã</option>
                        <option value="Doces">Doces</option>
                        <option value="Tapioca">Tapioca</option>
                        <option value="Promocoes">Promoções</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="formRight">
            <div class="input">
                <h4>Descrição</h4>
                <textarea id="edit-descricao" name="descricao_produto" placeholder="Digite a descrição"
                    required></textarea>
            </div>
            <div class="input">
                <h4>Quantidade</h4>
                <input type="number" id="edit-quantidade" name="quantidade" placeholder="Ex: 35" required>
            </div>
            <div class="input">
                <h4>Preço</h4>
                <input type="number" id="edit-preco" name="preco_produto" placeholder="Ex: 7.00" step="0.01" required>
            </div>
            <div class="submitBtns">
                <input type="hidden" id="edit-id-produto" name="id_produto">
                <button type="button" class="cancelar">Cancelar</button>
                <button type="submit" class="editar">Editar</button>
            </div>
        </div>
    </form>
    <div class="apagar">
        <div class="text">
            <h3>Confirmar exclusão</h3>
            <h4>Tem certeza que deseja deletar este lanche?</h4>
        </div>
        <div class="botoes">
            <button class="cancelar2">Cancelar</button>
            <button class="deletar">Deletar</button>
        </div>
    </div>
    <div class="sombraForm"></div>
    <div class="deleteForm"></div>
    <header>
        <div class="sandwich">
            <figure class="menu">
                <img src="../templates/assets/img/sandwichMenu.png" alt="">
            </figure>
            <div class="options">
                <div class="option">
                    <figure>
                        <img src="../templates/assets/img/cutlery.png" alt="">
                    </figure>
                    <h5>Cardápio</h5>
                </div>
                <div class="option">
                    <figure>
                        <img src="../templates/assets/img/coxinhaIcon.png" alt="">
                    </figure>
                    <h5>Pedidos</h5>
                </div>
                <div class="option">
                    <figure>
                        <img src="../templates/assets/img/chat.png" alt="">
                    </figure>
                    <h5>Feedbacks</h5>
                </div>
                <div class="option">
                    <figure>
                        <img src="../templates/assets/img/shoppingCart.png" alt="">
                    </figure>
                    <h5>Carrinho</h5>
                </div>
            </div>
        </div>
        <div class="sombra"></div>
        <figure class="logo">
            <img src="../templates/assets/img/Logo.png" alt="">
        </figure>
        <div class="headerButtons">
            <figure>
                <img class="back" src="../templates/assets/img/volte.png" alt="">
            </figure>
            <a href="<?php echo $urlPerfil; ?>">
            <figure>
                <img class="profileButton" src="../templates/assets/img/Profile.png" alt="">
            </figure>
            </a>
        </div>
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
                <div>
                    <h4 class="subtitle">Tipo</h4>
                    <h4 class="subtitle2"><?php echo $tipoProduto; ?></h4>
                </div>
                <div>
                    <h4 class="subtitle">Quantidade</h4>
                    <h4 class="subtitle2"><?php echo $quantidadeEstoque; ?></h4>
                </div>
            </div>
        </div>
    </main>
    <script src="../templates/assets/js/detalhamentoAdm.js"></script>
</body>

</html>
