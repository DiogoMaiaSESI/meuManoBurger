<?php

require_once '../vendor/autoload.php';
use Controller\PedidoController;
use Controller\ProductController;
session_start();
$pedidoController = new PedidoController();
$productController = new ProductController();


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST['codigo'])){
        $codigo = $_POST['codigo'];
        $pedidoController->updateStatusPedido($codigo, 'Retirado');
    }
    if(!empty($_POST['codigoApagar'])){
        $codigo = $_POST['codigoApagar'];
        $pedidoController->updateStatusPedido($codigo, 'Cancelado');
    }
}

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
                <a href="empresa.php">
                    <figure class="voltar">
                        <img src="../templates/assets/img/voltar.png" alt="">
                    </figure>
                </a>
                <a href="perfil_adm.php">
                    <figure class="perfil">
                        <img src="../templates/assets/img/perfil.png" alt="">
                    </figure>
                </a>
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
                    <div class="resumos">
                        <?php 
                        foreach ($pedidos as $pedido => $value) {
                            $pedido_produto = $pedidoController->getPedidoProdutoById($pedidoController->getIdPedidoByCodigo($value['codigo'])['id_pedido']);
                            $arrayPedidosQtd = [];
                            foreach ($pedido_produto as $item) {
                                $productName = $productController->findById($item['id_produto_fk'])['nome_produto'];
                                $arrayPedidosQtd[] = ['nome_produto' => $productName, 'qtd' => $item['qtd']];
                                echo '
                                <div class="resumolanche">
                                <p class="nomelanche">'. $arrayPedidosQtd['nome_produto'] .'</p>
                                <p class="qtdlanche">' . $arrayPedidosQtd['qtd'] . 'x</p>
                                </div>';                            
                            }
                        }
                        ?>
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

        <div class="modalconfirmexclusion">
            <div class="conteudomodalconfirmexclusion">

                <h2>Confirmação de cancelamento</h2>
                <p>Tem certeza que deseja cancelar o pedido?<span style="display: block;">(Essa ação é permanente)</span></p>
                <div class="modalbotoesexclusion">
                    <button class="simexclusion">Sim</button>
                    <button class="naoexclusion">Não</button>
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

                <?php
                foreach ($pedidos as $pedido => $value) {
                    list($data, $hora) = explode(' ', $value['retirada']);
                    $pedido_produto = $pedidoController->getPedidoProdutoById($pedidoController->getIdPedidoByCodigo($value['codigo'])['id_pedido']);
                    $arrayPedidosQtd = [];
                    if($value['status']==='Retirado') {
                        echo '<script>localStorage.setItem(`pedido_' . $value['codigo'] . '`, "retirado")</script>';
                    }
                    foreach ($pedido_produto as $item) {
                        $productName = $productController->findById($item['id_produto_fk'])['nome_produto'];
                        $arrayPedidosQtd[] = ['nome_produto' => $productName, 'qtd' => $item['qtd']];
                    }
                    echo '
                    <div class="pedido">
                    <div class="ilustracao">
                        '; if($value['status'] == 'A retirar') {
                            echo '
                            <div class="statuspendente">
                            <p class="statuspend">
                                A retirar
                            </p>
                            </div>
                            ';
                        } else if ($value['status'] == 'Retirado') {
                            echo '
                            <div class="statusretirado">
                            <p class="statusok">
                                Retirado
                            </p>
                            </div>
                            ';
                        } else if ($value['status'] == 'Cancelado') {
                            echo '
                            <div class="statuscancelado">
                            <p class="statuscanc">
                                Cancelado
                            </p>
                            </div>
                            ';
                        } echo '
                        <figure>
                            <img src="../templates/assets/img/ilustracao.png" alt="">
                        </figure>
                    </div>

                    <div class="central">

                        <div class="centralline1">
                            <div class="codigopedidos">
                                <p class="inforcodigo">Código:
                                <p class="codigo">' . $value['codigo'] . '</p>
                                </p>
                            </div>

                            <div class="totalpedidos">
                                <p class="infortotal">Total:
                                <p class="total">R$ ' . number_format($value['total'],2,',', '.') . '</p>
                                </p>
                            </div>

                        </div>

                        <div class="centralline2">

                            <div class="horapedidos">
                                <figure>
                                    <img src="../templates/assets/img/relogio.png" alt="">
                                </figure>
                                <p class="hora">' . substr($hora,0,-3) . '</p>
                            </div>

                            <div class="datapedidos">
                                <figure>
                                    <img src="../templates/assets/img/calendario.png" alt="">
                                </figure>
                                <p class="data">' . str_replace('-','/',$data) . '</p>
                            </div>

                        </div>
                    </div>

                    <div class="botoes">
                        <div class="org">
                            <button class="detalhes" data-array="' . htmlspecialchars(json_encode($arrayPedidosQtd), ENT_QUOTES, 'UTF-8') . '">Ver Detalhes</button>
                            '; if ($value['status'] != 'Cancelado') {
                                echo '<button class="lixeira"><img src="../templates/assets/img/Lixeira.png"></button>';
                            } echo'
                        </div>
                        '; if ($value['status'] != 'Cancelado') {
                            echo '<button class="statusbtn">O pedido foi retirado?</button>';
                        } echo'
                    </div>
                </div>
                    ';
                }
                ?>
            </div>
            

        </div>
        <form method="POST"><input class="postPedido" name="codigo" type="hidden"><input class="apagarPedido" name="codigoApagar" type="hidden"></form>
    </main>
    <audio id="notificationSound" src="../templates/assets/audio/notification.mp3" preload="auto"></audio>

<script>
let lastId = null;

function verificarPedidos() {
    fetch("../Model/NovoPedido.php")
        .then(response => response.text())
        .then(id => {
            id = Number(id);
            
            if (lastId === null) {
                lastId = id; // primeira vez carregando
            } else if (id > lastId) {
                // Novo pedido detectado!
                lastId = id;
                document.getElementById("notificationSound").play();
                document.getElementById("notificationSound").onended = () => {
                    location.reload();
                }
            }
        });
}

// verificar a cada 3 segundos
setInterval(verificarPedidos, 3000);
</script>
    <script src="../templates/assets/js/pedidosADM.js"></script>
</body>

</html>