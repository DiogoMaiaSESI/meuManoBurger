<?php
namespace Controller;

require_once __DIR__ . '/../Config/Cliente.php';

use Model\Cliente;
use Exception;

class ClienteController{
    private $clienteModel;

    public function __construct(Cliente $clienteModel){
            $this->clienteModel = $clienteModel;
    }

    public function createCliente($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente){
        if(empty($nome_cliente) || empty($email_cliente) || empty($senha_cliente)){
            return false;
        }

        return $this->clienteModel->registerClienteUser($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente);
    }

    public function checkClienteByEmail($email_cliente){
        return $this -> clienteModel -> getClienteByEmail($email_cliente);
    }

    public function login($email_cliente, $senha_cliente){
        $cliente = $this -> clienteModel -> getClienteByEmail($email_cliente);

        if($cliente && password_verify($senha_cliente, $cliente['senha_cliente'])){
            $_SESSION['id_cliente '] = $cliente['id_cliente'];
            $_SESSION['email_cliente'] = $cliente['email_cliente'];
            $_SESSION['senha_cliente'] = $cliente['senha_cliente'];
            $_SESSION['imagem_cliente'] = $cliente['imagem_cliente'];

            var_dump($_SESSION);
            return true;
        } else {
            return false;
        }
    }

    public function isLoggedIn(){
        return isset($_SESSION['id_cliente']);
    }

    public function getClietneData($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente){
        return $this -> clienteModel -> getClienteInfo($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente);
    }
}    

?>