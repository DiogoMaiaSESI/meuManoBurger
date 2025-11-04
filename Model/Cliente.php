<?php

namespace Model;

require_once __DIR__ . '/../Model/Connection.php';

use Model\Connection;
use PDO;
use PDOException;
use Exception;

class Cliente{
    private $db;

    public function __construct(){
            $this->db = Connection::getInstance(); 
    }

    public function registerClienteUser($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente){
        try{
            $sql = 'INSERT INTO cliente(nome_cliente, email_cliente, senha_cliente, imagem_cliente) VALUES (:nome_cliente, :email_cliente, :senha_cliente, :imagem_cliente)';
        
            $hashedPassword = password_hash($senha_cliente,  PASSWORD_DEFAULT);

            $stmt = $this -> db -> prepare($sql);

            $stmt -> bindParam(":nome_cliente", $nome_cliente, PDO::PARAM_STR);
            $stmt -> bindParam(":email_cliente", $email_cliente, PDO::PARAM_STR);
            $stmt -> bindParam(":senha_cliente", $hashedPassword, PDO::PARAM_STR);
            $stmt -> bindParam(":imagem_cliente", $imagem_cliente, PDO::PARAM_LOB);

            return $stmt -> execute();
        } catch (PDOException $error){
            echo "Erro ao executar comando:  " . $error->getMessage();
            return false;
        }
    }
    public function updateCliente($id_cliente, $nome_cliente, $email_cliente, $imagem_cliente) {
    try {
        $sql = 'UPDATE cliente SET nome_cliente = :nome_cliente, email_cliente = :email_cliente';
        
        if ($imagem_cliente !== null) {
            $sql .= ', imagem_cliente = :imagem_cliente';
        }
        
        $sql .= ' WHERE id_cliente = :id_cliente';

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
        $stmt->bindParam(":nome_cliente", $nome_cliente, PDO::PARAM_STR);
        $stmt->bindParam(":email_cliente", $email_cliente, PDO::PARAM_STR);

        if ($imagem_cliente !== null) {
            $stmt->bindParam(":imagem_cliente", $imagem_cliente, PDO::PARAM_LOB);
        }

        return $stmt->execute();

    } catch (PDOException $error) {
        echo "Erro ao atualizar cliente: " . $error->getMessage();
        return false;
    }
}

    public function getClienteByEmail($email_cliente){
        try{
            $sql = 'SELECT * FROM cliente WHERE email_cliente = :email_cliente LIMIT 1';

            $stmt = $this -> db -> prepare($sql);
            
            $stmt -> bindParam(":email_cliente", $email_cliente, PDO::PARAM_STR);

            $stmt -> execute();

            return $stmt -> fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $error){
            echo "Erro ao resgatar usuário pelo email: " . $error->getMessage();
            return false;
        }
    }

    public function getClienteInfo($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente){
        try{
            $sql = 'SELECT * FROM cliente WHERE nome_cliente = :nome_cliente AND email_cliente = :email_cliente AND senha_cliente = :senha_cliente AND imagem_cliente = :imagem_cliente LIMIT 1';

            $stmt = $this -> db -> prepare($sql);
            
            $stmt -> bindParam(":nome_cliente", $nome_cliente, PDO::PARAM_STR);
            $stmt -> bindParam(":email_cliente", $email_cliente, PDO::PARAM_STR);
            $stmt -> bindParam(":senha_cliente", $senha_cliente, PDO::PARAM_STR);
            $stmt -> bindParam(":imagem_cliente", $imagem_cliente, PDO::PARAM_LOB);

            $stmt -> execute();

            return $stmt -> fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $error){
            echo "Erro ao resgatar usuário pelas informações: " . $error->getMessage();
            return false;
        }
    }
}
?>