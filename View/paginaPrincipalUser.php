<?php
session_start();


require_once('../Controller/ClienteController.php');
require_once('../Controller/FeedbackController.php');
use Controller\ClienteController;
$clienteController = new ClienteController();

if($_SESSION['id_cliente'] !== null) {
    $id_cliente = $_SESSION['id_cliente'];
} else {
    header('Location: login.php');
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['product_id'])){
        $_SESSION['product_id_details'] = $_POST['product_id'];
        header('Location: detalhamentoUser.php');
        exit;
    }
}

$imagemCliente = $clienteController->getClienteById($id_cliente)['imagem_cliente'];



// --- 3. PREPARAÇÃO DE DADOS PARA RENDERIZAR A PÁGINA (Método GET) ---

// Instancia os controllers para buscar dados
$feedbackModel = new \Model\Feedback();
$feedbackController = new \Controller\FeedbackController($feedbackModel);

// Busca todos os feedbacks para exibir na página
$feedbacks = $feedbackController->listAll();

// Verifica se o cliente está logado para mostrar o botão de adicionar
$isClienteLoggedIn = isset($_SESSION['id_cliente']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../templates/assets/img/Logo.png">
    <link rel="stylesheet" href="../templates/assets/css/paginaPrincipalUser.css">
    <style>
        .feedbackcontainer {
            margin-bottom: 3.0rem;
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 100;
            display: none;
            justify-content: center;
            align-items: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .modal-content h2 {
            margin-top: 0;
            color: var(--VermelhoCereja);
            margin-bottom: 2.0rem;
            font-size: 2.5rem;
        }
        .modal-content p {
            margin-bottom: 2.0rem;
            font-size: 1.5rem;
        }

        .modal-content textarea {
            width: 100%;
            min-height: 150px;
            padding: 0.5rem;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .modal-content .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .modal-content button {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: bold;
        }

        .modal-content .btn-submit {
            background-color: var(--AmareloPrimario);
            color: #333;
        }

        .modal-content .btn-cancel {
            background-color: #eee;
        }

        .close-modal {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 2rem;
            font-weight: bold;
            cursor: pointer;
            color: #888;
        }
    </style>
    <title>Home | MeuManoBurger</title>
</head>

<body>
    <header>
        <div class="menu_logo">
            <div class="sandwich">
                <figure class="menu">
                    <img src="../templates/assets/img/menuSanduiche.png" alt="Menu">
                </figure>
                <div class="options">
                    <div class="option">
                        <figure><img src="../templates/assets/img/cutlery.png" alt=""></figure>
                        <h5>Cardápio</h5>
                    </div>
                    <div class="option">
                        <figure><img src="../templates/assets/img/coxinhaIcon.png" alt=""></figure>
                        <h5>Pedidos</h5>
                    </div>
                    <div class="option">
                        <figure><img src="../templates/assets/img/chat.png" alt=""></figure>
                        <h5>Feedbacks</h5>
                    </div>
                    <div class="option" id="carrinho_sandwich">
                        <figure><img src="../templates/assets/img/shoppingCart.png" alt=""></figure>
                        <h5>Carrinho</h5>
                    </div>
                </div>
                </div>
            </div>
            <div class="sombra"></div>
            
                <figure class="figure_logo">
                    <img src="../templates/assets/img/Logo.png" alt="">
                </figure>
            
            
            <div class="carrinho_perfil">
                <a href="carrinho.php">
                    <figure>
                        <img class="carrinhoPerfilImg" src="../templates/assets/img/carrinho.png" alt="">
                    </figure>
                </a>
                
                <a href="perfil.php">
                    <figure class="perfilFigure">
                        <img class="profileButton" src="data:image/jpeg;base64,<?php echo base64_encode($imagemCliente);?>" alt="">
                    </figure>
                </a>
            </div>
    </header>

    <main>
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../templates/assets/img/imgcarousel.png" class="d-block w-100" alt="Promoção">
                </div>
            </div>
        </div>
    </main>

    <section>
        <div class="container_menu">
            <div class="config_menu" id="hamburgueres">
                <figure><img class="hambBtn" src="../templates/assets/img/hamburgueres.png" alt="Hamburgueres"></figure>
                <h2>Hambúrgueres</h2>
            </div>
            <div class="config_menu" id="lanches">
                <figure><img class="lancBtn" src="../templates/assets/img/lanches.png" alt="Lanches"></figure>
                <h2>Lanches</h2>
            </div>
            <div class="config_menu" id="bebidas">
                <figure><img class="bebBtn" src="../templates/assets/img/bebidas.png" alt="Bebidas"></figure>
                <h2>Bebidas</h2>
            </div>
            <div class="config_menu" id="cafe_manha">
                <figure><img class="cafeBtn" src="../templates/assets/img/cafedamanha.png" alt="Café da manhã"></figure>
                <h2>Café da manhã</h2>
            </div>
            <div class="config_menu" id="doces">
                <figure><img class="docesBtn" src="../templates/assets/img/doces.png" alt="Doces"></figure>
                <h2>Doces</h2>
            </div>
            <div class="config_menu" id="Tapioca">
                <figure><img class="tapBtn" src="../templates/assets/img/tapioca.png" alt="Tapioca"></figure>
                <h2>Tapiocas</h2>
            </div>
            <div class="config_menu" id="promocoes">
                <figure><img class="promBtn" src="../templates/assets/img/promocoes.png" alt="Promoções"></figure>
                <h2>Promoções</h2>
            </div>
        </div>
    </section>

    <section class="sessaomaispedidos">
        <div class="maispedidos">
            <div class="maispedidostitulo">
                <h2>Mais Pedidos</h2>
            </div>
            <p class="maispedidossubtitulo">Conheça os mais famosos entre a galera e saiba exatamente o que pedir!</p>
            <div class="maispedidoscards">
                <div class="card">
                    <figure><img src="../templates/assets/img/esfirra.png" alt=""></figure>
                    <p id="17" class="nomedopedido">Esfirra de Carne</p>
                </div>
                <div class="card">
                    <figure><img src="../templates/assets/img/pastel.png" alt=""></figure>
                    <p id="14" class="nomedopedido">Pastel Frito</p>
                </div>
                <div class="card">
                    <figure><img src="../templates/assets/img/coxinha.png" alt=""></figure>
                    <p id="16" class="nomedopedido">Coxinha de Queijo</p>
                </div>
                <div class="card">
                    <figure><img src="../templates/assets/img/hamburguer.png" alt=""></figure>
                    <p id="4" class="nomedopedido">Hamburguer</p>
                </div>
                <div class="card">
                    <figure><img src="../templates/assets/img/paopizza.png" alt=""></figure>
                    <p id="21" class="nomedopedido">Pão Pizza</p>
                </div>
                <div class="card">
                    <figure><img src="../templates/assets/img/empada_menu.png" alt=""></figure>
                    <p id="19" class="nomedopedido">Empada</p>
                </div>
                <div class="card">
                    <figure><img src="../templates/assets/img/cuscuz_menu.png" alt=""></figure>
                    <p id="22" class="nomedopedido">Cuscuz</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cardapio">
        <div class="container_cardapio">
            <div class="saiba_mais">
                <h1>Cardápio</h1>
                <div class="informacao_cardapio">
                    <p>Descubra os sabores que vão conquistar você, confira nosso cardápio!</p>
                    <button class="saibaBtn">Saiba Mais</button>
                </div>
            </div>
            <div class="img_cardapio">
                <figure><img src="../templates/assets/img/img_cardapio.png" alt=""></figure>
            </div>
        </div>
        <figure class="icone_cardapio">
            <img src="../templates/assets/img/icone_cardapio.png" alt="">
        </figure>
    </section>

    <hr>

    <section class="feedback" id="feedback">
        <div class="textostitulo">
            <h2 class="feed">Feedbacks</h2>
            <h3 class="frase"> Visualize os <span class="word">feedbacks</span> enviados!</h3>
        </div>
        <div class="feedbackcontainer">
            <?php if (empty($feedbacks)): ?>
                <p>Ainda não há feedbacks. Seja o primeiro a comentar!</p>
            <?php else: ?>
                <?php foreach ($feedbacks as $fb): ?>
                    <div class="caixa">
                        <div class="dados">
                            <figure>
                                <img src="<?php echo ($fb['imagem_cliente'] ? 'data:image/jpeg;base64,' . base64_encode($fb['imagem_cliente']) : '../templates/assets/img/perfil.png'); ?>"
                                    alt="Foto de <?php echo htmlspecialchars($fb['nome_cliente']); ?>">
                            </figure>
                            <p><?php echo htmlspecialchars($fb['nome_cliente']); ?></p>
                        </div>
                        <div class="textofeedback">
                            <p><?php echo htmlspecialchars($fb['descricao_feedback']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
        </div>
        <?php if ($isClienteLoggedIn): ?>
            <button id="btn-add-feedback" class="saibaBtn" style="margin-top: 2rem; width: auto; padding: 0 2rem;">Deixar meu Feedback</button>
        <?php endif; ?>

        
    </section>

    <!-- O HTML do Modal de Feedback -->
    <div id="modal-feedback" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Deixe seu Feedback</h2>
            <p>Sua opinião é muito importante para nós!</p>
            <form action="paginaPrincipalUser.php" method="POST">
                <input type="hidden" name="action" value="create_feedback">
                <textarea name="descricao_feedback" placeholder="Digite seu comentário aqui..." required></textarea>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel">Cancelar</button>
                    <button type="submit" class="btn-submit">Enviar Feedback</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <h3>Copyright © 2025 Meumanoburger- Todos os Direitos Reservados</h3>
    </footer>

    <form method="POST"><input class="product_id" type="hidden" name="product_id"></form>

    <script src="../templates/assets/js/PaginaPrincipalUser.js"></script>
</body>

</html>