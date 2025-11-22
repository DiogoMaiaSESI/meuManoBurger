<?php

namespace Model;
use Model\Connection;

use PDO;
use PDOException;
use Exception;

class Favorito {
    private $db;

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    public function getAllFavoritesByClient ($id_cliente) {
        try {
            $sql = 'SELECT id_produto_fk FROM favorito WHERE id_cliente_fk = :id_cliente_fk';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cliente_fk', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao pegar favoritos pelo id do cliente: ' . $e);
        }
    }

    public function createFavorite ($id_produto, $id_cliente) {
        try {
            $sql = 'INSERT INTO favorito (id_produto_fk, id_cliente_fk) VALUES (:id_produto_fk, :id_cliente_fk)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_produto_fk', $id_produto, PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente_fk', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception('Erro ao inserir favorito: ' . $e);
        }
    }
    
    public function deleteFavorite ($id_produto, $id_cliente) {
        try {
            $sql = 'DELETE FROM favorito WHERE id_produto_fk = :id_produto_fk and id_cliente_fk = :id_cliente_fk';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_produto_fk', $id_produto, PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente_fk', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception('Erro ao deletar favorito: ' . $e);
        }
    }

    public function getSingleProduct ($id_cliente, $id_produto) {
        try {
            $sql = 'SELECT * FROM favorito WHERE id_produto_fk = :id_produto_fk and id_cliente_fk = :id_cliente_fk';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_produto_fk', $id_produto, PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente_fk', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao selecionar produto específico: ' . $e);
        }
    }
}

?>