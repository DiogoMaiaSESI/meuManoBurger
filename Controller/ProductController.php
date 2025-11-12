<?php

namespace Controller;

use Model\Product;
use Model\Estoque;

class ProductController {
    private $productModel;
    private $estoqueModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->estoqueModel = new Estoque();
    }

    public function create() {
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
        $nome = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_SPECIAL_CHARS);
        $preco = filter_input(INPUT_POST, 'preco_produto', FILTER_VALIDATE_FLOAT);
        $tipo = filter_input(INPUT_POST, 'tipo_produto', FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = filter_input(INPUT_POST, 'descricao_produto', FILTER_SANITIZE_SPECIAL_CHARS);
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $id_adm_fk = $_SESSION['id_adm'] ?? null;
        if (!$id_adm_fk) {
            $_SESSION['error_message'] = "Erro de autenticação. Faça login novamente.";
            header('Location: cadastro_produto.php');
            exit;
        }

        $imagem = null;
        if (isset($_FILES['imagem_produto']) && $_FILES['imagem_produto']['error'] == UPLOAD_ERR_OK) {
            $imagem = file_get_contents($_FILES['imagem_produto']['tmp_name']);
        }

        // 1. Tenta criar o produto
        $result = $this->productModel->createProduct($nome, $preco, $tipo, $descricao, $imagem, $id_adm_fk);

        if ($result['success']) {
            // 2. Se o produto foi criado, pega o ID do novo produto
            $id_produto_criado = $result['last_id'];
            
            // 3. Insere a quantidade inicial no estoque
            $estoqueSuccess = $this->estoqueModel->insertestoque($quantidade, $id_produto_criado);

            if ($estoqueSuccess) {
                $_SESSION['success_message'] = "Produto e estoque cadastrados com sucesso!";
            } else {
                // Opcional: Lidar com o caso onde o produto foi criado mas o estoque falhou.
                $_SESSION['error_message'] = "Produto criado, mas falha ao cadastrar o estoque.";
            }
        } else {
            // Se a criação do produto falhou, pega os erros
            $errors = implode(', ', $result['errors']);
            $_SESSION['error_message'] = "Erro ao cadastrar produto: " . $errors;
        }

        // Redireciona de volta para a página de cadastro para mostrar a mensagem
        header('Location: cadastro_produto.php');
        exit;

    }

    public function update() {
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

    public function delete() {
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
