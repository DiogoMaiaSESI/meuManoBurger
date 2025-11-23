<?php
session_start();
if($_SESSION['id_adm'] !== null) {
    $idAdm = $_SESSION['id_adm'];
} else {
    header('Location: login.php');
}

require_once __DIR__ . '/../Controller/AdmController.php';
$admController = new \Controller\AdmController();

$imagem_adm = $admController->getAdmById($idAdm)['imagem_adm'];

require_once __DIR__ . '/../Controller/AdmController.php';
require_once __DIR__ . '/../Model/Feedback.php'; // Inclui o Model de Feedback
require_once __DIR__ . '/../Controller/FeedbackController.php'; // Inclui o Controller de Feedback

// 2. Instancia os controllers
$admController = new \Controller\AdmController();
$feedbackModel = new \Model\Feedback();
$feedbackController = new \Controller\FeedbackController($feedbackModel);

// 3. Busca os dados
$imagem_adm = $admController->getAdmById($idAdm)['imagem_adm'];
$feedbacks = $feedbackController->listAll(); // Busca todos os feedbacks do banco
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página Principal Empresa</title>
        <link rel="stylesheet" href="../templates/assets/css/empresa.css">
    </head>
    <body>
        <header>
            <div class="sandwich">
                <figure class="menu">
                    <img src="../templates/assets/img/menu.png" alt="">
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
                </div>
            </div>
            <div class="sombra"></div>
            <div class="cabecalho">
                <figure class="logo">
                    <img src="../templates/assets/img/logo.png" alt="">
                </figure>
                <figure class="perfil perfilFigure">
                    <img class="profileButton" src="data:image/jpeg;base64,<?php echo base64_encode($imagem_adm);?>" alt="">
                </figure>
            </div>
        </header>
        <main>
            <figure class="hamburger">
                <img src="../templates/assets/img/hamburger.png" alt="" class="hambImg">
            </figure>
            <h1 class="title">Controle o <span>fluxo de pedidos</span> e realize o atendimento com agilidade</h1>
        </main>
        <div class="decoracao1">
            <figure class="decComp">
                <img src="../templates/assets/img/decoracao.png" alt="Decoração vermelha">
            </figure>
            <figure class="decTab">
                <img src="../templates/assets/img/decoracaotablet.png" alt="Decoração vermelha">
            </figure>
            <figure class="decCel">
                <img src="../templates/assets/img/decoracaocelular.png" alt="Decoração vermelha">
            </figure>
        </div>
        <section class="cardapio">
            <div class="textoft">
                <div class="textbtn">
                    <h2 class="cardapiomenu">Menu</h2>
                    <div class="cardapioDiv">
                        <h3 class="textomenu">Atualize e visualize as informações dos seus produtos.</h3>
                        <button class="btncardapio">Meu Cardápio</button>
                    </div>
                </div>
                <div class="foto">
                    <figure>
                        <img src="../templates/assets/img/coxinha1.png" alt="">
                    </figure>
                </div>
            </div>
            <div class="decoracao2">
                <figure class="decComp">
                    <img src="../templates/assets/img/decoracao.png" alt=" Decoração vermelha 2">
                </figure>
                <figure class="decTab">
                    <img src="../templates/assets/img/decoracaotablet.png" alt="Decoração vermelha">
                </figure>
                <figure class="decCel">
                    <img src="../templates/assets/img/decoracaocelular.png" alt="Decoração vermelha">
                </figure>
            </div>
            <hr>
        </section>
        <section class="feedback" id="feedback">
        <div class="textostitulo">
            <h2 class="feed">Feedbacks</h2>
            <h3 class="frase"> Visualize os <span class="word">feedbacks</span> enviados!</h3>
        </div>

        <!-- [CORREÇÃO NO HTML DO FEEDBACK] -->
        <!-- Usando a mesma estrutura do index.php -->
        <div class="feedbackcontainer">
            <?php if (empty($feedbacks)): ?>
                <p style="font-size: 1.8rem; color: #555; text-align: center; width: 100%;">Nenhum feedback encontrado no banco de dados.</p>
            <?php else: ?>
                <?php foreach ($feedbacks as $fb): ?>
                    <div class="caixa">
                        <div class="dados">
                            <figure>
                                <!-- Lógica para mostrar imagem do cliente ou uma padrão -->
                                <img src="<?php echo ($fb['imagem_cliente'] ? 'data:image/jpeg;base64,' . base64_encode($fb['imagem_cliente']) : '../templates/assets/img/perfil.png'); ?>" alt="Foto de <?php echo htmlspecialchars($fb['nome_cliente']); ?>">
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
    </section>
        <footer>
            <h4>Copyright © 2025 Meumanoburger - Todos os Direitos Reservados</h4>
        </footer>
        <script src="../templates/assets/js/empresa.js"></script>
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