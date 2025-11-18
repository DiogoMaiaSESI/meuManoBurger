<?php
session_start();

// 1. INCLUSÕES E LÓGICA DE DADOS
require_once __DIR__ . '/Model/Feedback.php';
require_once __DIR__ . '/Controller/FeedbackController.php';

$feedbackModel = new \Model\Feedback();
$feedbackController = new \Controller\FeedbackController($feedbackModel);

// Busca todos os feedbacks para exibir na página
$feedbacks = $feedbackController->listAll();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial | MeuManoBurger</title>
    <link rel="stylesheet" href="templates/assets/css/index.css">
</head>

<body>
    <header>
        <figure class="icone">
            <img src="templates/assets/img/iconeheader.png" alt="Ícone">
        </figure>

        <div class="cabecalho">
            <button class="nav-button" data-target="#home">Home</button>
            <button class="nav-button" data-target="#mais-pedidos">Mais Pedidos</button>
            <figure>
                <img src="templates/assets/img/logoCentro.png" alt="Logo MeuManoBurger">
            </figure>
            <button class="nav-button" data-target="#sobre-nos">Sobre Nós</button>
            <button class="nav-button" data-target="#feedback">Feedbacks</button>
        </div>

        <button class="login">Entrar</button>
    </header>

    <main id="home">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="templates/assets/img/foto-carrossel.png" class="d-block w-100" alt="Promoção">
                </div>
            </div>
        </div>
    </main>

    <section class="sessaomaispedidos" id="mais-pedidos">
        <div class="maispedidos">
            <div class="maispedidostitulo">
                <h2>Mais Pedidos</h2>
                <figure>
                    <img src="templates/assets/img/fogo.png" alt="Ícone de fogo">
                </figure>
            </div>
            <p class="maispedidossubtitulo">Conheça os mais famosos entre a galera e saiba exatamente o que pedir!</p>
            <div class="maispedidoscards">
                <div class="card">
                    <figure><img src="templates/assets/img/esfirra.png" alt=""></figure>
                    <p class="nomedopedido">Esfirra de Carne</p>
                </div>
                <div class="card">
                    <figure><img src="templates/assets/img/pastel.png" alt=""></figure>
                    <p class="nomedopedido">Pastel Frito</p>
                </div>
                <div class="card">
                    <figure><img src="templates/assets/img/coxinha.png" alt=""></figure>
                    <p class="nomedopedido">Coxinha de Queijo</p>
                </div>
                <div class="card">
                    <figure><img src="templates/assets/img/hamburguer.png" alt=""></figure>
                    <p class="nomedopedido">Hamburguer</p>
                </div>
            </div>
        </div>
    </section>

    <section class="sobrenos" id="sobre-nos">
        <figure class="elementocima"><img src="templates/assets/img/elemento_cima.png" alt=""></figure>
        <figure class="sobre"><img src="templates/assets/img/sobrenos.png" alt="Sobre Nós"></figure>
        <figure class="elementobaixo"><img src="templates/assets/img/elemento_baixo.png" alt=""></figure>
    </section>

    <section class="feedback" id="feedback">
        <h3>Feedbacks</h3>
        <p class="subtitulo">Seu <span class="word">Feedback</span> é muito importante para nós!</p>
        
        <!-- [INÍCIO DA MUDANÇA] Estrutura dinâmica com scroll horizontal -->
        <div class="feedbackcontainer">
            <?php if (empty($feedbacks)): ?>
                <p style="font-size: 1.8rem; color: #555;">Nenhum feedback encontrado.</p>
            <?php else: ?>
                <?php foreach ($feedbacks as $fb): ?>
                    <div class="caixa">
                        <div class="dados">
                            <figure>
                                <img src="<?php echo ($fb['imagem_cliente'] ? 'data:image/jpeg;base64,' . base64_encode($fb['imagem_cliente']) : 'templates/assets/img/perfil.png'); ?>" alt="Foto de <?php echo htmlspecialchars($fb['nome_cliente']); ?>">
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
        <!-- [FIM DA MUDANÇA] -->
    </section>

    <footer>
        <div class="footerinfor">
            <div class="caixafooter">
                <div class="localizacao">
                    <h4>Localização</h4>
                    <p>Av. Jorge Amado, S/N - Jardim Limoeiro, Camaçari - BA, 42800-605</p>
                    <a href="https://maps.app.goo.gl/y8V4YGhHkGGMXnf28" target="_blank">
                        <figure><img src="templates/assets/img/maps.png" alt=""></figure>
                    </a>
                </div>
                <div class="decoracao1">
                    <figure><img src="templates/assets/img/decoracao_baixo.png" alt=""></figure>
                </div>
                <div class="contato">
                    <h4>Contatos</h4>
                    <p class="telefone">(71 ) 9 8245-7654</p>
                    <p class="email">meumanoburguer@gmail.com</p>
                    <div class="redessociais">
                        <figure><img src="templates/assets/img/facebooklogo.png" alt=""></figure>
                        <figure><img src="templates/assets/img/instagramlogo.png" alt=""></figure>
                        <figure><img src="templates/assets/img/youtubelogo.png" alt=""></figure>
                    </div>
                </div>
            </div>
            <div class="decoracao2">
                <figure><img src="templates/assets/img/decoracao_cima.png" alt=""></figure>
            </div>
        </div>
        <h5>Copyright © 2025 Meumanoburger- Todos os Direitos Reservados</h5>
    </footer>
    <script src="templates/assets/js/index.js"></script>
</body>
</html>
