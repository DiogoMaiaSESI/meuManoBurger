<?php

namespace Controller;
use Model\Adm;
use Exception;

class AdmController {
    private $AdmModel; 

    public function __construct(){
        $this->AdmModel = new Adm();
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

    public function login ($email_adm, $senha_adm){
         $adm = $this->AdmModel->getAdmByEmail($email_adm);
         if ($adm && password_verify($senha_adm, $adm['senha_adm'])) {
            $_SESSION['id_adm'] = $adm['id_adm'];
            $_SESSION['nome_adm'] = $adm['nome_adm'];
            $_SESSION['email_adm'] = $adm['email_adm'];
            return true;
        }
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
}

?>