<?php

namespace Model;
use Model\Connection;

use PDO;
use PDOException;
use Exception;


class Carrinho {
    private $db;

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    public function getAllCartProducts ($id_cliente_fk) {
        try {
            $sql = 'SELECT * FROM carrinho WHERE id_cliente_fk = :id_cliente_fk';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cliente_fk', $id_cliente_fk, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao pegar produtos no carrinho: ' . $e);
        }
    }

    public function addProductToCart ($id_cliente_fk, $id_produto_fk) {
        try {
            $sql = 'INSERT INTO carrinho (qtd_produto, id_produto_fk, id_cliente_fk) VALUES (1, :id_produto_fk, :id_cliente_fk)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_produto_fk', $id_produto_fk, PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente_fk', $id_cliente_fk, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception('Erro ao adicionar produto ao carrinho: ' . $e);
        }
    }

    public function sumOneToProduct ($id_cliente_fk, $id_produto_fk) {
        try {
            $sql = 'UPDATE carrinho SET qtd_produto = qtd_produto + 1 WHERE id_cliente_fk = :id_cliente_fk AND id_produto_fk = :id_produto_fk';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cliente_fk', $id_cliente_fk, PDO::PARAM_INT);
            $stmt->bindParam(':id_produto_fk', $id_produto_fk, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception ('Erro ao somar produto: ' . $e);
        }
    }
    public function subtractOneToProduct ($id_cliente_fk, $id_produto_fk) {
        try {
            $sql = 'UPDATE carrinho SET qtd_produto = qtd_produto - 1 WHERE id_cliente_fk = :id_cliente_fk AND id_produto_fk = :id_produto_fk';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cliente_fk', $id_cliente_fk, PDO::PARAM_INT);
            $stmt->bindParam(':id_produto_fk', $id_produto_fk, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception ('Erro ao subtrair produto: ' . $e);
        }
    }

    public function deleteCartProduct ($id_cliente_fk, $id_produto_fk) {
        try {
            $sql = 'DELETE FROM carrinho WHERE $id_cliente_fk = :id_cliente_fk AND id_produto_fk = :id_produto_fk';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_produto_fk', $id_produto_fk, PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente_fk', $id_cliente_fk, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception('Erro ao deletar produto do carrinho: ' . $e);
        }
    }

    public function getProductById ($id_produto_fk, $id_cliente_fk) {
        try {
            $sql = 'SELECT * FROM carrinho WHERE id_produto_fk = :id_produto_fk AND id_cliente_fk = :id_cliente_fk';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_produto_fk', $id_produto_fk, PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente_fk', $id_cliente_fk, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception ('Erro ao pegar produto do carrinho pelo id: ' . $e);
        }
    }
}

?>