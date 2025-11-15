<?php

require_once '../vendor/autoload.php';
use Controller\PedidoController;
session_start();
$pedidoController = new PedidoController();
$pedidos = $pedidoController->getAllPedidos();

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link rel="stylesheet" href="../templates/assets/css/pedidosADM.css">
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

            <div class="lateral">

                <figure class="voltar">
                    <img src="../templates/assets/img/voltar.png" alt="">
                </figure>

                <figure class="perfil">
                    <img src="../templates/assets/img/perfil.png" alt="">
                </figure>


            </div>
        </div>
    </header>

    <main>
        <div class="modaldetalhes">
            <div class="conteudomodaldetalhes">
                <div class="fechar">
                    <figure>
                        <img src="../templates/assets/img/x.png" alt="">
                    </figure>
                </div>

                <div class="modaldados">

                    <figure class="modalilustracao">
                        <img src="../templates/assets/img/ilustracao.png" alt="">
                    </figure>

                    <div class="modalcodigopedidos">
                        <p class="codigotitulo">Código
                        <p class="codigotexto">ut4-z</p>
                        </p>
                    </div>

                    <div class="modaldata">
                        <figure>
                            <img src="../templates/assets/img/calendario.png" alt="">
                        </figure>
                        <p>21-11-2025</p>
                    </div>

                    <div class="modalhora">
                        <figure>
                            <img src="../templates/assets/img/relogio.png" alt="">
                        </figure>
                        <p>11:00</p>
                    </div>
                </div>

                <div class="resumopedido">
                    <p class="resumotitulo">Resumo do Pedido</p>

                    <div class="resumolanche">
                        <p class="nomelanche">Hamburguer</p>
                        <p class="qtdlanche">2x</p>
                    </div>

                    <div class="resumolanche">
                        <p class="nomelanche">Coca-cola</p>
                        <p class="qtdlanche">1x</p>
                    </div>

                    <div class="resumolanche">
                        <p class="nomelanche">Esfirra</p>
                        <p class="qtdlanche">3x</p>
                    </div>
                </div>

                <div class="modalstatus">
                    <p>A retirar</p>
                </div>
            </div>
        </div>

        <div class="modalconfirm">
            <div class="conteudomodalconfirm">

                <h2>Confirmação de retirada</h2>
                <p>Tem certeza que o pedido foi retirado?</p>
                <div class="modalbotoes">
                    <button class="sim">Sim</button>
                    <button class="nao">Não</button>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="infortitulo">
                <h1>Seus Pedidos</h1>

                <div class="pesquisa">

                    <div class="conjunto">
                        <figure>
                            <img src="../templates/assets/img/lupa.png" alt="">
                        </figure>

                            <input type="text" placeholder="Busque pelos seus pedidos através do código, hora ou data!">

                    </div>

                    <button class="btn">Buscar</button>
                </div>
            </div>



            <div class="pedidos">

                <div class="pedido">

                    <div class="ilustracao">
                            <div class="statusretirado">
                        <p class="statusok">
                            Retirado
                        </p>
                        </div>
                        <div class="statuspendente">
                        <p class="statuspend">
                            A retirar
                        </p>
                        </div>
                        <figure>
                            <img src="../templates/assets/img/ilustracao.png" alt="">
                        </figure>
                    </div>

                    <div class="central">

                        <div class="centralline1">
                            <div class="codigopedidos">
                                <p class="inforcodigo">Código:
                                <p class="codigo">utz-z</p>
                                </p>
                            </div>

                            <div class="totalpedidos">
                                <p class="infortotal">Total:
                                <p class="total">R$ 15,00</p>
                                </p>
                            </div>

                        </div>

                        <div class="centralline2">

                            <div class="horapedidos">
                                <figure>
                                    <img src="../templates/assets/img/relogio.png" alt="">
                                </figure>
                                <p class="hora">11:00</p>
                            </div>

                            <div class="datapedidos">
                                <figure>
                                    <img src="../templates/assets/img/calendario.png" alt="">
                                </figure>
                                <p class="data">21-11-2025</p>
                            </div>

                        </div>
                    </div>

                    <div class="botoes">
                        <button class="detalhes">Ver Detalhes</button>
                        <button class="statusbtn">O pedido foi retirado?</button>
                    </div>
                </div>

                <div class="pedido">

                    <div class="ilustracao">
                        <div class="statusretirado">
                            <p class="statusok">
                                Retirado
                            </p>
                        </div>
                        <div class="statuspendente">
                            <p class="statuspend">
                                A retirar
                            </p>
                        </div>
                        <figure>
                            <img src="../templates/assets/img/ilustracao.png" alt="">
                        </figure>
                    </div>

                    <div class="central">

                        <div class="centralline1">
                            <div class="codigopedidos">
                                <p class="inforcodigo">Código:
                                <p class="codigo">lh4-x</p>
                                </p>
                            </div>

                            <div class="totalpedidos">
                                <p class="infortotal">Total:
                                <p class="total">R$ 23,60</p>
                                </p>
                            </div>

                        </div>

                        <div class="centralline2">

                            <div class="horapedidos">
                                <figure>
                                    <img src="../templates/assets/img/relogio.png" alt="">
                                </figure>
                                <p class="hora">09:00</p>
                            </div>

                            <div class="datapedidos">
                                <figure>
                                    <img src="../templates/assets/img/calendario.png" alt="">
                                </figure>
                                <p class="data">10-10-2025</p>
                            </div>

                        </div>
                    </div>

                    <div class="botoes">
                        <button class="detalhes">Ver Detalhes</button>
                        <button class="statusbtn">O pedido foi retirado?</button>
                    </div>
                </div>

                <div class="pedido">

                    <div class="ilustracao">
                        <div class="statusretirado">
                            <p class="statusok">
                                Retirado
                            </p>
                        </div>
                        <div class="statuspendente">
                            <p class="statuspend">
                                A retirar
                            </p>
                        </div>
                        <figure>
                            <img src="../templates/assets/img/ilustracao.png" alt="">
                        </figure>
                    </div>

                    <div class="central">

                        <div class="centralline1">
                            <div class="codigopedidos">
                                <p class="inforcodigo">Código:
                                <p class="codigo">p09-3</p>
                                </p>
                            </div>

                            <div class="totalpedidos">
                                <p class="infortotal">Total:
                                <p class="total">R$ 5,00</p>
                                </p>
                            </div>

                        </div>

                        <div class="centralline2">

                            <div class="horapedidos">
                                <figure>
                                    <img src="../templates/assets/img/relogio.png" alt="">
                                </figure>
                                <p class="hora">12:00</p>
                            </div>

                            <div class="datapedidos">
                                <figure>
                                    <img src="../templates/assets/img/calendario.png" alt="">
                                </figure>
                                <p class="data">16-09-2025</p>
                            </div>

                        </div>
                    </div>

                    <div class="botoes">
                        <button class="detalhes">Ver Detalhes</button>
                        <button class="statusbtn">O pedido foi retirado?</button>
                    </div>
                </div>

                <div class="pedido">

                    <div class="ilustracao">
                        <div class="statusretirado">
                            <p class="statusok">
                                Retirado
                            </p>
                        </div>
                        <div class="statuspendente">
                            <p class="statuspend">
                                A retirar
                            </p>
                        </div>
                        <figure>
                            <img src="../templates/assets/img/ilustracao.png" alt="">
                        </figure>
                    </div>

                    <div class="central">

                        <div class="centralline1">
                            <div class="codigopedidos">
                                <p class="inforcodigo">Código:
                                <p class="codigo">df7-t</p>
                                </p>
                            </div>

                            <div class="totalpedidos">
                                <p class="infortotal">Total:
                                <p class="total">R$ 28,00</p>
                                </p>
                            </div>

                        </div>

                        <div class="centralline2">

                            <div class="horapedidos">
                                <figure>
                                    <img src="../templates/assets/img/relogio.png" alt="">
                                </figure>
                                <p class="hora">08:30</p>
                            </div>

                            <div class="datapedidos">
                                <figure>
                                    <img src="../templates/assets/img/calendario.png" alt="">
                                </figure>
                                <p class="data">20-08-2025</p>
                            </div>

                        </div>
                    </div>

                    <div class="botoes">
                        <button class="detalhes">Ver Detalhes</button>
                        <button class="statusbtn">O pedido foi retirado?</button>
                    </div>
                </div>

            </div>


        </div>
    </main>
    <script src="../templates/assets/js/pedidosADM.js"></script>
</body>

</html>