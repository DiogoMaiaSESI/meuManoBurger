<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../templates/assets/css/cadastro.css">
    <link rel="icon" href="../templates/assets/img/Logo.png">
    <title>Cadastro | MeuManoBurger</title>
</head>

<body>
    <main>
        <div class="container">
            <div class="imagem_login">
                <img src="../templates/assets/img/imglogin-cadastro.png"
                    alt="Uma mulher sentada em uma cadeira com um notebook no colo, com um celular na página de login atrás">
            </div>
            <div class="formContainer">
                <div class="form_cadastro">
                    <h1>Seja Bem-Vindo ao MeumanoBurger</h1>
                    <h2>Cadastre-se</h2>
                    <p>E aproveite nossos recursos</p>
                    <form>
                        <div class="inputs">
                            <div class="foto">
                                <label for="imagemPerfil">
                                    <p class="adfoto"> Adicionar Foto</p>
                                    <figure class="foto-do-perfil">
                                        <img id="previewImagem" src="../templates/assets/img/perfil.png"
                                            alt="Imagem do perfil" />
                                    </figure>
                                </label>
                                <input type="file" id="imagemPerfil" name="imagemPerfil" accept="image/*"
                                    style="display: none;">
                            </div>
                        </div>
    
                        <p class="labelInput">Nome</p>
                        <input type="text" name="nome" id="nome" required>
    
                        <p class="labelInput">Email</p>
                        <input type="email" name="email" id="email" required>
    
                        <p class="labelInput">Senha</p>
                        <input type="password" name="password" id="password" required>
    
                        <p class="labelInput">Confirmar Senha</p>
                        <input type="password" name="confirm_password" id="confirm_password" required>
    
                        <p class="msg_erro">As senhas não coincidem</p>
    
                        <button type="submit">Cadastrar</button>
                        
                        <div class="google_facebook">
                            <figure class="google">
                                <a href=""> <!--Link para autenticação com o Google-->
                                    <img src="../templates/assets/img/google.png" alt="Logo do Google">
                                </a>
                            </figure>
    
                            <figure class="facebook">
                                <a href=""> <!--Link para autenticação com o Facebook-->
                                    <img src="../templates/assets/img/facebook.png" alt="Logo do Facebook">
                                </a>
                            </figure>
                        </div>
                        <p class="login"> Já tem uma conta? <span>Login</span></p>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </main>
    <footer></footer>
    <script src="../templates/assets/js/cadastro.js"></script>
</body>

</html>