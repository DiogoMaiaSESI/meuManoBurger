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
            $sql = 'DELETE FROM carrinho WHERE id_cliente_fk = :id_cliente_fk AND id_produto_fk = :id_produto_fk';
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

    public function deleteAllClientCart ($id_cliente_fk) {
        try {
            $sql = 'DELETE FROM carrinho WHERE id_cliente_fk = :id_cliente_fk';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cliente_fk', $id_cliente_fk, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception('Erro ao deletar tudo do carrinho: ' . $e);
        }
    }
    public function getCartTotalValue($idCliente) {
    try {
        $sql = "SELECT SUM(p.preco_produto * c.qtd_produto) as total
                FROM carrinho c
                JOIN produto p ON c.id_produto_fk = p.id_produto
                WHERE c.id_cliente_fk = :idCliente";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Retorna o valor total, ou 0 se o carrinho estiver vazio
        return $result['total'] ?? 0.0;

    } catch (PDOException $e) {
        error_log("Erro ao calcular total do carrinho: " . $e->getMessage());
        return 0.0;
    }
}
}

?>