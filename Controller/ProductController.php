<?php

namespace Controller;

use Model\Product;

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function create($nome, $preco, $tipo, $descricao, $imagem, $id_adm_fk) {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return ['success' => false, 'errors' => ['Requisição inválida.']];
        }

        $nome = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_SPECIAL_CHARS);
        $preco = filter_input(INPUT_POST, 'preco_produto', FILTER_VALIDATE_FLOAT);
        $tipo = filter_input(INPUT_POST, 'tipo_produto', FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = filter_input(INPUT_POST, 'descricao_produto', FILTER_SANITIZE_SPECIAL_CHARS);
        $id_adm_fk = filter_input(INPUT_POST, 'id_adm_fk', FILTER_VALIDATE_INT);

        $imagem = null;
        if (isset($_FILES['imagem_produto']) && $_FILES['imagem_produto']['error'] == UPLOAD_ERR_OK) {
            $fileType = mime_content_type($_FILES['imagem_produto']['tmp_name']);
            if (in_array($fileType, ['image/jpeg', 'image/png', 'image/gif'])) {
                 $imagem = file_get_contents($_FILES['imagem_produto']['tmp_name']);
            }
        }

        return $this->productModel->createProduct($nome, $preco, $tipo, $descricao, $imagem, $id_adm_fk);
    }

    public function update($id, $nome, $preco, $tipo, $descricao, $imagem, $id_adm_fk) {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return ['success' => false, 'errors' => ['Requisição inválida.']];
        }

        $id = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT);
        $nome = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_SPECIAL_CHARS);
        $preco = filter_input(INPUT_POST, 'preco_produto', FILTER_VALIDATE_FLOAT);
        $tipo = filter_input(INPUT_POST, 'tipo_produto', FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = filter_input(INPUT_POST, 'descricao_produto', FILTER_SANITIZE_SPECIAL_CHARS);
        $id_adm_fk = filter_input(INPUT_POST, 'id_adm_fk', FILTER_VALIDATE_INT);

        $imagem = null;
        if (isset($_FILES['imagem_produto']) && $_FILES['imagem_produto']['error'] == UPLOAD_ERR_OK) {
            $imagem = file_get_contents($_FILES['imagem_produto']['tmp_name']);
        }

        return $this->productModel->updateProduct($id, $nome, $preco, $tipo, $descricao, $imagem, $id_adm_fk);
    }

    public function delete($id) {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return ['success' => false, 'errors' => ['Requisição inválida.']];
        }
        
        $id = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT);

        return $this->productModel->deleteProduct($id);
    }

    public function listAll() {
        return $this->productModel->getAllProducts();
    }

    public function findById($id) {
        $cleanId = filter_var($id, FILTER_VALIDATE_INT);
        return $this->productModel->getProductById($cleanId);
    }
    public function toggleFavoriteAction() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return ['success' => false, 'errors' => ['Requisição inválida.']];
        }

        $userId = $_SESSION['user_id'] ?? null;
        $productId = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT);

        if (!$userId) {
            return ['success' => false, 'errors' => ['Você precisa estar logado para gerenciar favoritos.']];
        }


        return $this->productModel->toggleFavorite($userId, $productId);
    }


    public function listFavorites() {

        $userId = $_SESSION['user_id'] ?? null;
        
        if (!$userId) {
            return []; 
        }

        return $this->productModel->getFavoritesByUser($userId);
    }
}
?>
