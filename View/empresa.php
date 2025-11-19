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
                <img src="../templates/assets/img/hamburguer.png" alt="" class="hambImg">
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
            <div class=" textostitulo">
                <h2 class="feed">Feedbacks</h2>
                <h3 class="frase"> Visualize os <span class="word">feedbacks</span> enviados!</h3>
            </div>
            <div class="feedbackcontainer">
                <div class="lineone">
                    <div class="caixa">
                        <div class="dados">
                            <figure>
                                <img src="../templates/assets/img/lucia.png" alt="">
                            </figure>
                            <p>Lúcia santos</p>
                        </div>
                        <div class="textofeedback">
                            <p>Mano, a cantina virou o point do
                                recreio! O "X-Mano" é monstro, vem recheado e barato.
                                Ainda salvam com aquele refri</p>
                        </div>
                    </div>
                    <div class="caixa">
                        <div class="dados">
                            <figure>
                                <img src="../templates/assets/img/julia.png" alt="">
                            </figure>
                            <p>Júlia Costa</p>
                        </div>
                        <div class="textofeedback">
                            <p>Atendem muito rápido, o que é essencial para o pouco
                                tempo do recreio. Os lanches são saborosos e noto
                                que as crianças estão adorando.</p>
                        </div>
                    </div>
                </div>
                <div class="linetwo">
                    <div class="caixa">
                        <div class="dados">
                            <figure>
                                <img src="../templates/assets/img/Rodrigo.png" alt="">
                            </figure>
                            <p>Rodrigo Carvalho</p>
                        </div>
                        <div class="textofeedback">
                            <p>Achei uma iniciativa excelente. Preços acessíveis e o
                                cardápio é mais atrativo e saudável do que a
                                cantina anterior, que só vendia salgados fritos.</p>
                        </div>
                    </div>
                    <div class="caixa">
                        <div class="dados">
                            <figure>
                                <img src="../templates/assets/img/joao.png" alt="">
                            </figure>
                            <p>João da Silva</p>
                        </div>
                        <div class="textofeedback">
                            <p>Parabéns ao "Meu Mano Burger" pela qualidade.
                                É raro encontrar uma cantina escolar que se
                                preocupe tanto com a procedência dos ingredientes.</p>
                        </div>
                    </div>
                </div>
        </section>
        <footer>
            <h4>Copyright © 2025 Meumanoburger - Todos os Direitos Reservados</h4>
        </footer>
        <script src="../templates/assets/js/empresa.js"></script>
    </body>
</html>