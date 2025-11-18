<?php

namespace Model;

require_once __DIR__ . '/../Model/Connection.php';

use PDO;
use PDOException;

class Feedback {
    private $db;

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    public function create($descricao, $idCliente) {
        try {
            $sql = "INSERT INTO feedbacks (descricao_feedback, id_cliente_fk) VALUES (:descricao, :id_cliente)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindParam(':id_cliente', $idCliente, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao criar feedback: " . $e->getMessage());
            return false;
        }
    }

    public function getAll() {
        try {
            // Usamos um JOIN para buscar os dados do feedback E os dados do cliente (nome e imagem) de uma só vez.
            $sql = "SELECT 
                        f.descricao_feedback, 
                        f.data_criacao, 
                        c.nome_cliente, 
                        c.imagem_cliente 
                    FROM feedbacks f
                    JOIN cliente c ON f.id_cliente_fk = c.id_cliente
                    ORDER BY f.data_criacao DESC"; // Mostra os mais recentes primeiro
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar feedbacks: " . $e->getMessage());
            return [];
        }
    }
}
?>