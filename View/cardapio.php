<?php
    
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
                <img src="../templates/assets/img/adicionar.png" alt="">
            </figure>
        </div>
        <div class="container">
                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/classico.png" alt="Hambúrguer Clássico">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Clássico</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/duplobacon.png"
                            alt="Hambúrguer Duplo Bacon">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Duplo Bacon</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/triplocheddar.png"
                            alt="Hambúrguer Triplo Cheddar">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Triplo Cheddar</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/xtudo.png" alt="Hambúrguer X-Tudo">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">X-Tudo</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>


                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/duploburguer.png" alt="Hambúrguer Clássico">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Duplo Burguer</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/xegg.png"
                            alt="Hambúrguer Duplo Bacon">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">X-Egg</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/xbacon.png"
                            alt="Hambúrguer Triplo Cheddar">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">X-Bacon</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/xsalada.png" alt="Hambúrguer X-Tudo">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">X-Salada</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

        </div>
    </section>
    <section class="lanc">
       <div class="add-product">
            <h1>Hambúrgueres</h1>

            <figure>
                <img src="../templates/assets/img/adicionar.png" alt="">
            </figure>
        </div>

       <div class="container">
                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/pastel_carne.png" alt="Pastel de carne">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Pastel de Carne</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/Bauru_frango.png"
                            alt="Bauru de Frango">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Bauru de Frango</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/coxinha.png"
                            alt="Coxinha">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Coxinha</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/esfirra.png" alt="Esfirra">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Esfirra</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>
        

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/quibe.png" alt="Quibe">
                    </div>
                    <div class="informacoes_config">
                    <h3 class="product-title">Quibe</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/empada.png"
                            alt="Empada">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Empada</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/enroladinho_salsicha.png"
                            alt="Enroladinho de Salsicha">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Enroladinho de Salsicha</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/pao_pizza.png" alt="Pão de Pizza">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Pão Pizza</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>
        </div>
    </section>
    <section class="beb">
        <div class="add-product">
            <h1>Hambúrgueres</h1>

            <figure>
                <img src="../templates/assets/img/adicionar.png" alt="">
            </figure>
        </div>
        
        <div class="container">

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/coca_cola.png" alt="Coca-Cola">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Coca-Cola (350ml)</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/guarana.png"
                            alt="Guaraná Antarctica">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Guaraná (350ml)</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/fys_guarana.png"
                            alt="Fys Guaraná">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Fys Guaraná (350ml)</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/fys_limao.png" alt="Fys Limão (350ml)">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Fys Limão (350ml)</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/agua.png" alt="Água Mineral">
                    </div>
                    <div class="informacoes_config">
                    <h3 class="product-title">Água (500ml)</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/suco_acerola.png"
                            alt="Suco de Acerola">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Suco de Acerola</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/suco_maracuja.png"
                            alt="Suco de Maracujá">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Suco de Maracujá</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/coca_zero.png" alt="Coca-Cola Zero">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Coca-Cola Zero</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>
            </div>

    </section>
    <section class="cafe">
        <div class="add-product">
            <h1>Hambúrgueres</h1>

            <figure>
                <img src="../templates/assets/img/adicionar.png" alt="">
            </figure>
        </div>

       <div class="container">
                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/cuscuz_cardapio.png" alt="Cuscuz">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Cuscuz</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/pao_ovo.png"
                            alt="Pão com Ovo">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Pão com Ovo</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/pao_manteiga.png"
                            alt="Pão com Manteiga">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Pão com Manteiga</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/pao_queijo.png" alt="Pão de Queijo">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Pão de Queijo</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/torrada.png" alt="Torrada">
                    </div>
                    <div class="informacoes_config">
                    <h3 class="product-title">Torrada</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class="doces">
        <div class="add-product">
            <h1>Hambúrgueres</h1>

            <figure>
                <img src="../templates/assets/img/adicionar.png" alt="">
            </figure>
        </div>

         <div class="container">

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/pacoquita.png" alt="Paçoquita">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Paçoquita</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/trident.png"
                            alt="Trident">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Trident</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/bolo_pote.png"
                            alt="Bolo de Pote">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Bolo de Pote</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/bala_caramelo.png" alt="Bala de Caramelo">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Bala de Caramelo</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/snickers.png" alt="Snickers">
                    </div>
                    <div class="informacoes_config">
                    <h3 class="product-title">Snickers</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/acai.png"
                            alt="Açaí">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Açaí (500ml)</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>
            </div>


    </section>
    <section class="tap">
        <div class="add-product">
            <h1>Hambúrgueres</h1>

            <figure>
                <img src="../templates/assets/img/adicionar.png" alt="">
            </figure>
        </div>

         <div class="container">

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/tapioca_charque.png" alt="Tapioca de Charque">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Tapioca de Charque</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/tapioca_mussarela.png"
                            alt="Tapioca de Mussarela">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Tapioca de Mussarela</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/tapioca_frango.png"
                            alt="Tapioca de Frango">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Tapioca de Frango</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>
        </div>

    </section>
    <section class="prom">
        <div class="add-product">
            <h1>Hambúrgueres</h1>

            <figure>
                <img src="../templates/assets/img/adicionar.png" alt="">
            </figure>
        </div>

        <div class="container">

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/Combo_aluno.png" alt="Combo Aluno">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Combo Aluno</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/combo_professor.png"
                            alt="Combo Professor">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Combo Professor</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/almoco_completo.png"
                            alt="Almoço Completo">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Almoço Completo</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>

                <div class="config_card">
                    <div class="product-image">
                        <img src="../templates/assets/img/Lanche_suco.png" alt="Lanche + Suco">
                    </div>
                    <div class="informacoes_config">
                        <h3 class="product-title">Lanche + Suco</h3>
                        <p class="product-price">R$ 7,00</p>
                        <button class="add-to-cart">
                            <figure>
                                <img src="../templates/assets/img/detalhes.png" alt="">
                            </figure>
                            Ver Detalhes
                        </button>
                    </div>
                </div>
        </div>
    </section>

    <footer>
        <h2>Copyright © 2025 Meumanoburguer - Todos os Direitos Reservados</h2>
    </footer>
    <script src="../templates/assets/js/cardapio.js"></script>
</body>

</html>