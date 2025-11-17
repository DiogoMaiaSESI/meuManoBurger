<?php

session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['product_id'])){
        $_SESSION['product_id_details'] = $_POST['product_id'];
        header('Location: detalhamentoUser.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../templates/assets/img/Logo.png">
    <link rel="stylesheet" href="../templates/assets/css/paginaPrincipalUser.css">
    <title>Home | MeuManoBurger</title>
</head>
<body>
    <header>
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
            </div>
            <div class="sombra"></div>
            
                <figure class="figure_logo">
                    <img src="../templates/assets/img/Logo.png" alt="">
                </figure>
            
            
            <div class="carrinho_perfil">
                <figure>
                    <img src="../templates/assets/img/carrinho.png" alt="">
                </figure>
                
                
                <figure>
                    <img src="../templates/assets/img/perfil.png" alt="">
                </figure>
            </div>
    </header>

    <main>
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../templates/assets/img/imgcarousel.png" class="d-block w-100" alt="...">
                </div>
            </div>
    </main>


    <section>
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
    </section>


      <section class="sessaomaispedidos">
        <div class="maispedidos">
            <div class="maispedidostitulo">
                <h2>Mais Pedidos</h2>
            </div>
            <p class="maispedidossubtitulo">Conheça os mais famosos entre a galera e saiba exatamente o que pedir!</p>

            <div class="maispedidoscards">
                <div class="card">
                    <figure>
                        <img src="../templates/assets/img/esfirra.png" alt="">
                    </figure>
                    <p id="17" class="nomedopedido">Esfirra de Carne</p>
                </div>

                <div class="card">
                    <figure>
                        <img src="../templates/assets/img/pastel.png" alt="">
                    </figure>
                    <p id="14" class="nomedopedido">Pastel Frito</p>
                </div>

                <div class="card">
                    <figure>
                        <img src="../templates/assets/img/coxinha.png" alt="">
                    </figure>
                    <p id="16" class="nomedopedido">Coxinha de Queijo</p>
                </div>

                <div class="card">
                    <figure>
                        <img src="../templates/assets/img/hamburguer.png" alt="">
                    </figure>
                    <p id="4" class="nomedopedido">Hamburguer</p>
                </div>

                <div class="card">
                    <figure>
                        <img src="../templates/assets/img/paopizza.png" alt="">
                    </figure>
                    <p id="21" class="nomedopedido">Pão Pizza</p>
                </div>

                <div class="card">
                    <figure>
                        <img src="../templates/assets/img/empada_menu.png" alt="">
                    </figure>
                    <p id="19" class="nomedopedido">Empada</p>
                </div>

                <div class="card">
                    <figure>
                        <img src="../templates/assets/img/cuscuz_menu.png" alt="">
                    </figure>
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
                <figure>
                    <img src="../templates/assets/img/img_cardapio.png" alt="">
                </figure>
            </div>

        </div>
            <figure class="icone_cardapio">
                <img src="../templates/assets/img/icone_cardapio.png" alt="">
            </figure>
        </section>
        
        <hr>

    <section class="feedback">
            <div class=" textostitulo">
                <h2 class="feed">Feedbacks</h2>
                <h3 class="frase"> Visualize os <span class="word">feedbacks</span> enviados!</h3>
            </div>
            <div class="feedbackcontainer">
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
            <h3>Copyright © 2025 Meumanoburger- Todos os Direitos Reservados</h3>
        </footer>
        <form method="POST"><input class="product_id" type="hidden" name="product_id"></form>
    <script src="../templates/assets/js/paginaPrincipalUser.js"></script>
</body>
</html>