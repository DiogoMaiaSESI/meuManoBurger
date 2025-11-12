<?php

namespace Controller;

use Exception;
use Model\Product;
use PDOException;

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function create($nome, $preco, $tipo, $descricao, $imagem, $id_adm_fk) {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return ['success' => false, 'errors' => ['Requisição inválida.']];
        }
        
        $nome_sanitizado = filter_var($nome, FILTER_SANITIZE_SPECIAL_CHARS);
        $preco_sanitizado = filter_var($preco, FILTER_VALIDATE_FLOAT);
        $tipo_sanitizado = filter_var($tipo, FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao_sanitizado = filter_var($descricao, FILTER_SANITIZE_SPECIAL_CHARS);
        $id_adm_fk_sanitizado = filter_var($id_adm_fk, FILTER_VALIDATE_INT);
        $imagem = null;
        if (isset($_FILES['imagem_produto']) && $_FILES['imagem_produto']['error'] == UPLOAD_ERR_OK) {
            $imagem = file_get_contents($_FILES['imagem_produto']['tmp_name']);
        }
        return $this->productModel->createProduct($nome_sanitizado, $preco_sanitizado, $tipo_sanitizado, $descricao_sanitizado, $imagem, $id_adm_fk_sanitizado);
    }

    public function update($id, $nome, $preco, $tipo, $descricao, $imagem, $id_adm_fk) {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return ['success' => false, 'errors' => ['Requisição inválida.']];
        }

        $id_sanitizado = filter_var($id, FILTER_VALIDATE_INT);
        $nome_sanitizado = filter_input($nome, FILTER_SANITIZE_SPECIAL_CHARS);
        $preco_sanitizado = filter_input($preco, FILTER_VALIDATE_FLOAT);
        $tipo_sanitizado = filter_input($tipo, FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao_sanitizado = filter_input($descricao, FILTER_SANITIZE_SPECIAL_CHARS);
        $id_adm_fk_sanitizado = filter_input($id_adm_fk, FILTER_VALIDATE_INT);

        $imagem = null;
        if (isset($_FILES['imagem_produto']) && $_FILES['imagem_produto']['error'] == UPLOAD_ERR_OK) {
            $imagem = file_get_contents($_FILES['imagem_produto']['tmp_name']);
        }

        return $this->productModel->updateProduct($id_sanitizado, $nome_sanitizado, $preco_sanitizado, $tipo_sanitizado, $descricao_sanitizado, $imagem, $id_adm_fk_sanitizado);
    }

    public function delete($id) {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return ['success' => false, 'errors' => ['Requisição inválida.']];
        }
        
        $id_sanitizado = filter_var($id, FILTER_VALIDATE_INT);

        return $this->productModel->deleteProduct($id_sanitizado);
    }

    public function listAll() {
        return $this->productModel->getAllProducts();
    }

    public function findById($id) {
        $cleanId = filter_var($id, FILTER_VALIDATE_INT);
        return $this->productModel->getProductById($cleanId);
    }
    public function toggleFavoriteAction($productId) {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return ['success' => false, 'errors' => ['Requisição inválida.']];
        }

        $userId = $_SESSION['user_id'] ?? null;
        $productId_sanitizado = filter_var($productId, FILTER_VALIDATE_INT);

        if (!$userId) {
            return ['success' => false, 'errors' => ['Você precisa estar logado para gerenciar favoritos.']];
        }


        return $this->productModel->toggleFavorite($userId, $productId_sanitizado);
    }


    public function listFavorites() {

        $userId = $_SESSION['user_id'] ?? null;
        
        if (!$userId) {
            return []; 
        }

        return $this->productModel->getFavoritesByUser($userId);
    }
    public function getProductsByType ($type) {
        try {
            $sanitizedType = filter_var($type, FILTER_SANITIZE_SPECIAL_CHARS);
            return $this->productModel->getProductsByType($sanitizedType);
        } catch (PDOException $e) {
            throw new Exception('Erro ao selecionar produtos pelo tipo: ' . $e);
        }
    }
}
?>