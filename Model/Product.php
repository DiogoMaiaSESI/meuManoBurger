<?php

namespace Model;

require_once __DIR__ . '/../Model/Connection.php';
use PDO;
use PDOException;

class Product
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    private function validate($nome, $preco, $tipo, $descricao, $id_adm_fk)
    {
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

    public function createProduct($nome, $preco, $tipo, $descricao, $imagem, $id_adm_fk)
    {
        try {
            $sql = "INSERT INTO produto (nome_produto, preco_produto, tipo_produto, descricao_produto, imagem_produto, id_adm_fk) VALUES (:nome, :preco, :tipo, :descricao, :imagem, :id_adm_fk)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindValue(':imagem', $imagem, PDO::PARAM_LOB); // Usar bindValue para LOB é mais seguro
            $stmt->bindParam(':id_adm_fk', $id_adm_fk, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return $this->conn->lastInsertId(); // Retorna o ID do produto criado
            }
            return false; // Retorna false se a execução falhar

        } catch (PDOException $e) {
            // Em um ambiente real, logar o erro é crucial.
            error_log("Erro ao criar produto no Model: " . $e->getMessage());
            return false;
        }
    }

    public function updateProduct($id, $nome, $preco, $tipo, $descricao, $imagem_conteudo, $update_image, $id_adm_fk)
    {

        try {
            // A query base
            $sql = "UPDATE produto SET nome_produto = :nome, preco_produto = :preco, tipo_produto = :tipo, descricao_produto = :descricao, id_adm_fk = :id_adm_fk";

            // [CORREÇÃO] Adiciona a atualização da imagem APENAS se o sinalizador for verdadeiro
            if ($update_image) {
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

            // [CORREÇÃO] Faz o bind do parâmetro da imagem APENAS se o sinalizador for verdadeiro
            if ($update_image) {
                $stmt->bindParam(':imagem', $imagem_conteudo, PDO::PARAM_LOB);
            }

            $success = $stmt->execute();

            return ['success' => $success];

        } catch (PDOException $e) {
            error_log("Erro ao atualizar produto: " . $e->getMessage());
            return ['success' => false, 'errors' => ['Ocorreu um erro no servidor.']];
        }
    }

    public function deleteProduct($id)
    {
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

    public function getAllProducts()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM produto");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar todos os produtos: " . $e->getMessage());
            return [];
        }
    }

    public function getProductById($id)
    {
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
    private function isFavorite($userId, $productId)
    {
        $stmt = $this->conn->prepare("SELECT id_favorito FROM favoritos WHERE id_cliente_fk = :userId AND id_produto_fk = :productId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch() !== false;
    }


    public function toggleFavorite($userId, $productId)
    {
        if (empty($userId) || empty($productId)) {
            return ['success' => false, 'errors' => ['Usuário ou produto inválido.']];
        }

        try {

            if ($this->isFavorite($userId, $productId)) {

                $stmt = $this->conn->prepare(
                    "DELETE FROM favoritos WHERE id_cliente_fk = :userId AND id_produto_fk = :productId"
                );
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
                $stmt->execute();

                return ['success' => true, 'action' => 'unfavorited'];
            } else {

                $stmt = $this->conn->prepare(
                    "INSERT INTO favoritos (id_cliente_fk, id_produto_fk) VALUES (:userId, :productId)"
                );
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
                $stmt->execute();

                return ['success' => true, 'action' => 'favorited'];
            }
        } catch (PDOException $e) {
            error_log("Erro ao alternar favorito: " . $e->getMessage());
            return ['success' => false, 'errors' => ['Ocorreu um erro no servidor.']];
        }
    }

    public function getFavoritesByUser($userId)
    {
        if (empty($userId)) {
            return [];
        }

        try {

            $stmt = $this->conn->prepare(
                "SELECT p.* FROM produto p
                 JOIN favoritos f ON p.id_produto = f.id_produto_fk
                 WHERE f.id_cliente_fk = :userId"
            );
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar favoritos: " . $e->getMessage());
            return [];
        }
    }

    public function getProductsByType ($type) {
        try {
            $sql = 'SELECT * FROM produto WHERE tipo_produto = :tipo_produto';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':tipo_produto', $type, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception('Erro ao selecionar produtos pelo tipo: ' . $e);
        }
    }
}
?>
