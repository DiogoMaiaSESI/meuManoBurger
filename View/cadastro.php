<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../templates/assets/css/cadastro.css">
    <link rel="icon" href="../templates/assets/img/Logo.png">
    <title>Cadastro de Produto | MeuManoBurger</title>
</head>

<body>
    <main>
        <div class="container">
            <div class="logo">
                <img src="../templates/assets/img/Logo.png"
                    alt="A logo do MeuManoBurger">
            </div>
            <div class="formContainer">
                <div class="form_cadastro_produto">
                    <h1>Cadastre seu novo produto</h1>
                    <form>
                        <div class="inputs">
                            <div class="foto">
                                <label for="imagemProduto">
                                    <p class="adfoto"> Adicionar Foto</p>
                                    <figure class="foto-do-produto">
                                        <img id="previewImagem" src="../templates/assets/img/camera.png"
                                            alt="Imagem de camera para adicionar foto do produto" />
                                    </figure>
                                </label>
                                <input type="file" id="imagemProduto" name="imagemProduto" accept="image/*"
                                    style="display: none;">
                            </div>
                        </div>
    
                        <p class="labelInput">Nome</p>
                        <input type="text" name="nome" id="nome" required>
    
                        <p class="labelInput">Tipo</p>
                        <select name="opcoes_cardapio" id="opcoes_cardapio">
                            <option value="123"></option>
                            <option value="123"></option>   
                            <option value="123"></option>
                        </select>
                      
    
                        <p class="labelInput">Descrição</p>
                        <input type="text" name="descricao" id="descricao" required>
    
                        <p class="labelInput">Quantidade</p>
                        <input type="number" name="quantidade" id="quantidade" required>
    
                        <p class="labelInput">Preço</p>
                        <input type="number" name="preco" id="preco" set= 0.01 required>
    
                        <button type="submit">Cadastrar</button>
                        
                     
                        </div>
        
                    </form>
                </div>
            </div>
    </main>
    <footer></footer>
    <script src="../templates/assets/js/cadastro_produto.js"></script>
</body>

</html>