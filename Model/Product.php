<?php

namespace Model;

use PDO;
use PDOException;

class Product {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();
    }

    private function validate($nome, $preco, $tipo, $descricao, $id_adm_fk) {
        $errors = [];

        if (empty($nome)) {
            $errors[] = "O nome do produto é obrigatório.";
        }
        if (strlen($nome) > 255) {
            $errors[] = "O nome do produto não pode exceder 255 caracteres.";
        }
        if ($preco === false || $preco <= 0) {
            $errors[] = "O preço do produto deve ser um número positivo.";
        }
        if (empty($tipo)) {
            $errors[] = "O tipo do produto é obrigatório.";
        }
        if (empty($descricao)) {
            $errors[] = "A descrição do produto é obrigatória.";
        }
        if ($id_adm_fk === false || $id_adm_fk <= 0) {
            $errors[] = "O administrador responsável é inválido.";
        }
        
        return $errors;
    }

    public function createProduct($nome, $preco, $tipo, $descricao, $imagem, $id_adm_fk) {
        $validationErrors = $this->validate($nome, $preco, $tipo, $descricao, $id_adm_fk);
        if (!empty($validationErrors)) {
            return ['success' => false, 'errors' => $validationErrors];
        }

        try {
            $stmt = $this->conn->prepare("INSERT INTO produto (nome_produto, preco_produto, tipo_produto, descricao_produto, imagem_produto, id_adm_fk) VALUES (:nome, :preco, :tipo, :descricao, :imagem, :id_adm_fk)");
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindParam(':imagem', $imagem, PDO::PARAM_LOB);
            $stmt->bindParam(':id_adm_fk', $id_adm_fk, PDO::PARAM_INT);
            
            $success = $stmt->execute();
            
            return ['success' => $success];

        } catch (PDOException $e) {
            error_log("Erro ao criar produto: " . $e->getMessage());
            return ['success' => false, 'errors' => ['Ocorreu um erro no servidor ao tentar criar o produto.']];
        }
    }

    public function updateProduct($id, $nome, $preco, $tipo, $descricao, $imagem, $id_adm_fk) {
        $validationErrors = $this->validate($nome, $preco, $tipo, $descricao, $id_adm_fk);
        if (empty($id) || $id <= 0) {
            $validationErrors[] = "O ID do produto para atualização é inválido.";
        }
        if (!empty($validationErrors)) {
            return ['success' => false, 'errors' => $validationErrors];
        }
        
        try {
            $sql = "UPDATE produto SET nome_produto = :nome, preco_produto = :preco, tipo_produto = :tipo, descricao_produto = :descricao, id_adm_fk = :id_adm_fk";
            if ($imagem !== null) {
                $sql .= ", imagem_produto = :imagem";
            }
            $sql .= " WHERE id_produto = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindParam(':id_adm_fk', $id_adm_fk, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($imagem !== null) {
                $stmt->bindParam(':imagem', $imagem, PDO::PARAM_LOB);
            }

            $success = $stmt->execute();
            
            if ($stmt->rowCount() === 0) {
                 return ['success' => true, 'message' => 'Nenhum dado foi alterado.'];
            }

            return ['success' => $success];

        } catch (PDOException $e) {
            error_log("Erro ao atualizar produto: " . $e->getMessage());
            return ['success' => false, 'errors' => ['Ocorreu um erro no servidor ao tentar atualizar o produto.']];
        }
    }

    public function deleteProduct($id) {
        if (empty($id) || $id <= 0) {
            return ['success' => false, 'errors' => ['ID do produto inválido.']];
        }
        try {
            $stmt = $this->conn->prepare("DELETE FROM produto WHERE id_produto = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $success = $stmt->execute();
            if ($success && $stmt->rowCount() > 0) {
                return ['success' => true];
            } else {
                return ['success' => false, 'errors' => ['Produto não encontrado ou já deletado.']];
            }
        } catch (PDOException $e) {
            error_log("Erro ao deletar produto: " . $e->getMessage());
            return ['success' => false, 'errors' => ['Ocorreu um erro no servidor.']];
        }
    }

    public function getAllProducts() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM produto");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar todos os produtos: " . $e->getMessage());
            return [];
        }
    }

    public function getProductById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM produto WHERE id_produto = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar produto por ID: " . $e->getMessage());
            return null;
        }
    }
}
?>