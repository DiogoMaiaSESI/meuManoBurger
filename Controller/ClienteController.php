<?php
namespace Controller;

require_once __DIR__ . '/../Model/Cliente.php';

use Model\Cliente;
use Exception;

class ClienteController
{
    private $clienteModel;

    public function __construct(Cliente $clienteModel)
    {
        $this->clienteModel = $clienteModel;
    }

    public function createCliente($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente)
    {
        if (empty($nome_cliente) || empty($email_cliente) || empty($senha_cliente)) {
            return false;
        }

        return $this->clienteModel->registerClienteUser($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente);
    }

    public function checkClienteByEmail($email_cliente)
    {
        return $this->clienteModel->getClienteByEmail($email_cliente);
    }

    public function login($email_cliente, $senha_cliente)
    {
        $cliente = $this->clienteModel->getClienteByEmail($email_cliente);

        // Verifica se o cliente existe e se a senha está correta
        if ($cliente && password_verify($senha_cliente, $cliente['senha_cliente'])) {

            // Limpa qualquer sessão antiga para segurança
            session_regenerate_id(true);

            // Salva os dados necessários na sessão
            $_SESSION['id_cliente'] = $cliente['id_cliente'];
            $_SESSION['nome_cliente'] = $cliente['nome_cliente']; // ESSENCIAL para o perfil
            $_SESSION['email_cliente'] = $cliente['email_cliente'];
            $_SESSION['imagem_cliente'] = $cliente['imagem_cliente'];

            return true; // Login bem-sucedido
        }

        return false; // Login falhou
    }
    public function updateCliente($id_cliente, $nome_cliente, $email_cliente, $imagem_cliente)
    {
        if (empty($id_cliente) || empty($nome_cliente) || empty($email_cliente)) {
            return false;
        }

        // Chama o método do Model
        $success = $this->clienteModel->updateCliente($id_cliente, $nome_cliente, $email_cliente, $imagem_cliente);

        // Se a atualização foi bem-sucedida, atualiza os dados na sessão
        if ($success) {
            $_SESSION['nome_cliente'] = $nome_cliente;
            $_SESSION['email_cliente'] = $email_cliente;
            // Atualiza a imagem na sessão apenas se uma nova foi enviada
            if ($imagem_cliente !== null) {
                $_SESSION['imagem_cliente'] = $imagem_cliente;
            }
        }

        return $success;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['id_cliente']);
    }

    public function getClientData($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente)
    {
        return $this->clienteModel->getClienteInfo($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente);
    }
    public function updatePassword($id_cliente, $nova_senha, $confirmar_senha)
    {
        if (empty($id_cliente) || empty($nova_senha) || empty($confirmar_senha)) {
            $_SESSION['error_message'] = "Todos os campos de senha são obrigatórios.";
            return false;
        }
        if ($nova_senha !== $confirmar_senha) {
            $_SESSION['error_message'] = "As senhas não coincidem.";
            return false;
        }
        return $this->clienteModel->updatePassword($id_cliente, $nova_senha);
    }
}

?>