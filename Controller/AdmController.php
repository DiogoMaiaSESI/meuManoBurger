<?php

namespace Controller;

require_once __DIR__ . '/../Model/Adm.php';

use Model\Adm;
use Exception;

class AdmController {
    private $AdmModel; 

    public function __construct(Adm $AdmModel)
    {
        $this->AdmModel = $AdmModel;
    }
    

public function createAdm($nome_adm, $email_adm, $senha_adm, $imagem_adm = null) {
    
    if (empty($nome_adm) or empty($email_adm) or empty($senha_adm)) {
        throw new Exception("Todos os campos obrigatórios devem ser preenchidos");
    }
    
    if ($this->checkAdmByEmail($email_adm)) {
        throw new Exception("Email já cadastrado");
    }

    $senha_criptografada = password_hash($senha_adm, PASSWORD_DEFAULT);

    return $this->AdmModel->registerAdm($nome_adm, $email_adm, $senha_criptografada, $imagem_adm);
}

        public function checkAdmByEmail($email_adm)
    {
        return $this->AdmModel->getAdmByEmail($email_adm);
    }

    public function login($email_adm, $senha_adm)
    {
        // 1. Busca o administrador pelo e-mail.
        $adm = $this->AdmModel->getAdmByEmail($email_adm);

        // 2. Verifica se o ADM existe e se a senha está correta.
        if ($adm && password_verify($senha_adm, $adm['senha_adm'])) {
            
            // --- CORREÇÃO CRÍTICA ---
            // 3. Se a senha estiver correta, CRIA A SESSÃO COMPLETA.
            session_regenerate_id(true); // Medida de segurança para evitar session fixation.
            $_SESSION['id_adm'] = $adm['id_adm'];
            $_SESSION['nome_adm'] = $adm['nome_adm'];
            $_SESSION['email_adm'] = $adm['email_adm'];
            $_SESSION['imagem_adm'] = $adm['imagem_adm'];
            $_SESSION['is_admin'] = true; // A flag de segurança mais importante.

            // 4. Agora que a sessão está criada, retorna true para o login.php.
            return true;
        }

        // 5. Se a verificação falhar, retorna false.
        return false;
    }
    public function verifylogin()
    {
        return isset($_SESSION['id_adm']);
    }


    public function getAdmData($id_adm, $nome_adm, $email_adm)
    {
        return $this->AdmModel->getAdmInfo($id_adm, $nome_adm, $email_adm);
    }
    public function generate2FASecret($id_adm, $email_adm)
    {
        // Este método pode ser copiado diretamente do ClienteController,
        // apenas garantindo que ele chame o set2FASecret do AdmModel.
        try {
            $google2fa = new \PragmaRX\Google2FAQRCode\Google2FA();
            $secret = $google2fa->generateSecretKey();
            
            $this->AdmModel->set2FASecret($id_adm, $secret);

            $qrCodeUrl = $google2fa->getQRCodeInline('MeuManoBurger (Admin)', $email_adm, $secret);
            
            return ['success' => true, 'secret' => $secret, 'qrCodeUrl' => $qrCodeUrl];
        } catch (\Throwable $ex) {
            return ['success' => false, 'message' => 'Erro ao gerar 2FA: ' . $ex->getMessage()];
        }
    }

    public function verifyAndEnable2FA($id_adm, $secret, $code)
    {
        $google2fa = new \PragmaRX\Google2FAQRCode\Google2FA();
        $valid = $google2fa->verifyKey($secret, $code);

        if ($valid) {
            $this->AdmModel->enable2FA($id_adm);
            $_SESSION['success_message'] = 'Autenticação de 2 Fatores ativada com sucesso!';
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Código inválido. Tente novamente.'];
    }

    public function disable2FA($id_adm, $password)
    {
        $adm = $this->AdmModel->getAdmById($id_adm);
        if (!$adm || !password_verify($password, $adm['senha_adm'])) {
            return ['success' => false, 'message' => 'Senha incorreta.'];
        }
        if ($this->AdmModel->disable2FA($id_adm)) {
            $_SESSION['success_message'] = 'Autenticação de 2 Fatores desativada com sucesso!';
            return ['success' => true];
        }
        return ['success' => false, 'message' => 'Erro ao desativar a 2FA.'];
    }



    public function updateAdm($id_adm, $nome_adm, $email_adm, $imagem_adm_file)
    {
        if (empty($id_adm) || empty($nome_adm) || empty($email_adm)) {
            return false;
        }

        $imagem_conteudo = null;
        if (isset($imagem_adm_file) && $imagem_adm_file['error'] === UPLOAD_ERR_OK) {
            $imagem_conteudo = file_get_contents($imagem_adm_file['tmp_name']);
        }

        $success = $this->AdmModel->updateAdm($id_adm, $nome_adm, $email_adm, $imagem_conteudo);

        if ($success) {
            $_SESSION['nome_adm'] = $nome_adm;
            $_SESSION['email_adm'] = $email_adm;
            if ($imagem_conteudo !== null) {
                $_SESSION['imagem_adm'] = $imagem_conteudo;
            }
            $_SESSION['success_message'] = "Perfil atualizado com sucesso!";
        } else {
            $_SESSION['error_message'] = "Erro ao atualizar o perfil.";
        }
        header('Location: Perfil_adm.php');
        exit;
    }

    public function updatePassword($id_adm, $nova_senha, $confirmar_senha)
    {
        if (empty($id_adm) || empty($nova_senha) || empty($confirmar_senha)) {
            $_SESSION['error_message'] = "Todos os campos de senha são obrigatórios.";
            return false;
        }
        if ($nova_senha !== $confirmar_senha) {
            $_SESSION['error_message'] = "As senhas não coincidem.";
            return false;
        }
        
        $success = $this->AdmModel->updatePassword($id_adm, $nova_senha);
        if ($success) {
            $_SESSION['success_message'] = "Senha alterada com sucesso!";
        } else {
            $_SESSION['error_message'] = "Ocorreu um erro ao alterar a senha.";
        }
        header('Location: Perfil_adm.php#content-seguranca');
        exit;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['id_adm']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
    }

    public function logout()
    {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"] );
        }
        session_destroy();
        header("Location: login.php");
        exit;
    }
}

?>