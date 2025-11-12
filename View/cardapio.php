<?php
require_once('../vendor/autoload.php');
use Controller\ProductController;

// Inicia o controller de produtos
$productController = new ProductController();
$newProduct = null;
$targetCategoryClass = '';

// Verifica se um novo produto foi cadastrado e os parâmetros estão na URL
if (isset($_GET['new_product_id']) && isset($_GET['category_class'])) {
    $newProductId = filter_var($_GET['new_product_id'], FILTER_VALIDATE_INT);
    $targetCategoryClass = htmlspecialchars($_GET['category_class']);

    if ($newProductId) {
        // Busca os dados do produto recém-cadastrado pelo ID
        $newProduct = $productController->findById($newProductId);
    }
}
// Função para gerar o HTML de um card de produto
function renderProductCard($product) {
    // Formata o preço para o padrão brasileiro (R$ X,XX)
    $formattedPrice = 'R$ ' . number_format($product['preco_produto'], 2, ',', '.');
    // Converte a imagem (BLOB) para um formato que o HTML entende (Base64)
    $imageBase64 = 'data:image/jpeg;base64,' . base64_encode($product['imagem_produto']);

    // Retorna a estrutura HTML do card com os dados do produto
    return '
        <div class="config_card">
            <div class="product-image">
                <img src="' . $imageBase64 . '" alt="' . htmlspecialchars($product['nome_produto']) . '">
            </div>
            <div class="informacoes_config">
                <h3 class="product-title">' . htmlspecialchars($product['nome_produto']) . '</h3>
                <p class="product-price">' . $formattedPrice . '</p>
                <button class="add-to-cart">
                    <figure>
                        <img src="../templates/assets/img/detalhes.png" alt="Ícone de detalhes">
                    </figure>
                    Ver Detalhes
                </button>
            </div>
        </div>
    ';
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../templates/assets/img/Logo.png" />
    <link rel="stylesheet" href="../templates/assets/css/cardapio.css" />
    <title>Cardápio | MeuManoBurger</title>
</head>

<body>
    <header>
        <div class="container_header">

            <div class="menu_logo">
                <div class="sandwich">
                <figure class="menu">
                    <img src="../templates/assets/img/menuSanduiche.png" alt="">
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
                    <div class="option" id="carrinho_sandwich">
                        <figure>
                            <img src="../templates/assets/img/shoppingCart.png" alt="">
                        </figure>
                        <h5>Carrinho</h5>
                    </div>
                </div>
            </div>
            <div class="sombra"></div>

                <figure class="logo">
                    <img src="../templates/assets/img/Logo.png" alt="Logo MeuManoBurger" />
                </figure>
            </div>

            <div class="voltar_perfil">
                <figure class="voltar_header'">
                    <img src="../templates/assets/img/voltar_header.png" alt="Seta para voltar" />
                </figure>

                <figure class="carrinho_header">
                    <img src="../templates/assets/img/carrinho.png" alt="Carrinho" />
                </figure>

                <figure class="perfil_header">
                    <img src="../templates/assets/img/perfil.png" alt="Foto de perfil" />
                </figure>
            </div>
        </div>

        <div class="cardapio_promocoes">
            <h1 class="h1_cardapio">Cardápio</h1>
            <h1 class="h1_promocoes">Promoções</h1>
        </div>

        
    </header>

    <main>
        <div class="container_menu">

            <div class="config_menu" id="hamburgueres">
                <figure>
                    <img class="hambBtn" src="../templates/assets/img/hamburgueres.png" alt="Hamburgueres" />
                </figure>

                <h2>Hambúrgueres</h2>
            </div>

            <div class="config_menu" id="lanches">
                <figure>
                    <img class="lancBtn" src="../templates/assets/img/lanches.png" alt="Lanches" />
                </figure>

                <h2>Lanches</h2>
            </div>

            <div class="config_menu" id="bebidas">
                <figure>
                    <img class="bebBtn" src="../templates/assets/img/bebidas.png" alt="Bebidas" />
                </figure>

                <h2>Bebidas</h2>
            </div>

            <div class="config_menu" id="cafe_manha">
                <figure>
                    <img class="cafeBtn" src="../templates/assets/img/cafedamanha.png" alt="Café da manhã" />
                </figure>

                <h2>Café da manhã</h2>
            </div>

            <div class="config_menu" id="doces">
                <figure>
                    <img class="docesBtn" src="../templates/assets/img/doces.png" alt="Doces" />
                </figure>

                <h2>Doces</h2>
            </div>

            <div class="config_menu" id="Tapioca">
                <figure>
                    <img class="tapBtn" src="../templates/assets/img/tapioca.png" alt="Tapioca" />
                </figure>

                <h2>Tapiocas</h2>
            </div>

            <div class="config_menu" id="promocoes">
                <figure>
                    <img class="promBtn" src="../templates/assets/img/promocoes.png" alt="Promoções" />
                </figure>

                <h2>Promoções</h2>
            </div>
        </div>
    </main>

    <section class="hamb">
       
        <div class="add-product">
            <h1>Hambúrgueres</h1>

            <figure>
                <img class="adicionar_produto" src="../templates/assets/img/adicionar.png" alt="">
            </figure>
        </div>
        <div class="container">
            <?php 
            $hambs = $productController->getProductsByType('Hamburgueres');
            foreach ($hambs as $hamb => $value) {
                echo '<div class="config_card">
                    <div class="product-image">
                        <img src="' . 'data:image/jpeg;base64,' . base64_encode($value['imagem_produto']) . '" alt="' . htmlspecialchars($value['nome_produto']) . '" alt="Hambúrguer X-Tudo">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">' . htmlspecialchars($value['nome_produto']) . '</h3>
                        <p class="product-price">R$ '. number_format($value['preco_produto'], 2) .'</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>';
            } ?>
        </div>
    </section>
    <section class="lanc">
       <div class="add-product">
            <h1>Lanches</h1>

            <figure>
                <img class="adicionar_produto" src="../templates/assets/img/adicionar.png" alt="">
            </figure>
        </div>

       <div class="container">
            <?php 
            $lancs = $productController->getProductsByType('Lanches');
            foreach ($lancs as $lanc => $value) {
                echo '<div class="config_card">
                    <div class="product-image">
                        <img src="' . 'data:image/jpeg;base64,' . base64_encode($value['imagem_produto']) . '" alt="' . htmlspecialchars($value['nome_produto']) . '" alt="Hambúrguer X-Tudo">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">' . htmlspecialchars($value['nome_produto']) . '</h3>
                        <p class="product-price">R$ '. number_format($value['preco_produto'], 2) .'</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>';
            } ?>
        </div>
    </section>
    <section class="beb">
        <div class="add-product">
            <h1>Bebidas</h1>

            <figure>
                <img class="adicionar_produto" src="../templates/assets/img/adicionar.png" alt="">
            </figure>
        </div>
        
        <div class="container">
                <?php 
            $bebs = $productController->getProductsByType('Bebidas');
            foreach ($bebs as $beb => $value) {
                echo '<div class="config_card">
                    <div class="product-image">
                        <img src="' . 'data:image/jpeg;base64,' . base64_encode($value['imagem_produto']) . '" alt="' . htmlspecialchars($value['nome_produto']) . '" alt="Hambúrguer X-Tudo">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">' . htmlspecialchars($value['nome_produto']) . '</h3>
                        <p class="product-price">R$ '. number_format($value['preco_produto'], 2) .'</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>';
            } ?>
            </div>

    </section>
    <section class="cafe">
        <div class="add-product">
            <h1>Café da Manhã</h1>
            <figure>
                <img class="adicionar_produto" src="../templates/assets/img/adicionar.png" alt="">
            </figure>
        </div>

       <div class="container">
            <?php 
            $cafes = $productController->getProductsByType('Cafe da manha');
            foreach ($cafes as $cafe => $value) {
                echo '<div class="config_card">
                    <div class="product-image">
                        <img src="' . 'data:image/jpeg;base64,' . base64_encode($value['imagem_produto']) . '" alt="' . htmlspecialchars($value['nome_produto']) . '" alt="Hambúrguer X-Tudo">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">' . htmlspecialchars($value['nome_produto']) . '</h3>
                        <p class="product-price">R$ '. number_format($value['preco_produto'], 2) .'</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>';
            } ?>
            </div>
    </section>
    <section class="doces">
        <div class="add-product">
            <h1>Doces</h1>

            <figure>
                <img class="adicionar_produto" src="../templates/assets/img/adicionar.png" alt="">
            </figure>
        </div>

         <div class="container">
        <?php 
            $doces = $productController->getProductsByType('Doces');
            foreach ($doces as $doce => $value) {
                echo '<div class="config_card">
                    <div class="product-image">
                        <img src="' . 'data:image/jpeg;base64,' . base64_encode($value['imagem_produto']) . '" alt="' . htmlspecialchars($value['nome_produto']) . '" alt="Hambúrguer X-Tudo">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">' . htmlspecialchars($value['nome_produto']) . '</h3>
                        <p class="product-price">R$ '. number_format($value['preco_produto'], 2) .'</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>';
            } ?>
            </div>


    </section>
    <section class="tap">
        <div class="add-product">
            <h1>Tapioca</h1>

            <figure>
                <img class="adicionar_produto" src="../templates/assets/img/adicionar.png" alt="">
            </figure>
        </div>

         <div class="container">
            <?php
            $taps = $productController->getProductsByType('Tapioca');
            foreach ($taps as $tap => $value) {
                echo '<div class="config_card">
                    <div class="product-image">
                        <img src="' . 'data:image/jpeg;base64,' . base64_encode($value['imagem_produto']) . '" alt="' . htmlspecialchars($value['nome_produto']) . '" alt="Hambúrguer X-Tudo">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">' . htmlspecialchars($value['nome_produto']) . '</h3>
                        <p class="product-price">R$ '. number_format($value['preco_produto'], 2) .'</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>';
            } ?>
        </div>

    </section>
    <section class="prom">
        <div class="add-product">
            <h1>Promoções</h1>

            <figure>
                <img class="adicionar_produto" src="../templates/assets/img/adicionar.png" alt="">
            </figure>
        </div>

        <div class="container">
    <?php
            $proms = $productController->getProductsByType('Promocoes');
            foreach ($proms as $prom => $value) {
                echo '<div class="config_card">
                    <div class="product-image">
                        <img src="' . 'data:image/jpeg;base64,' . base64_encode($value['imagem_produto']) . '" alt="' . htmlspecialchars($value['nome_produto']) . '" alt="Hambúrguer X-Tudo">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">' . htmlspecialchars($value['nome_produto']) . '</h3>
                        <p class="product-price">R$ '. number_format($value['preco_produto'], 2) .'</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>';
            } ?>
        </div>
    </section>

    <footer>
        <h2>Copyright © 2025 Meumanoburguer - Todos os Direitos Reservados</h2>
    </footer>
    <script src="../templates/assets/js/cardapio.js"></script>
</body>

</html>