<?php

namespace Controller;

use Model\Product;
use Model\Estoque;

class ProductController
{
    private $productModel;
    private $estoqueModel;
    private $db; // Conexão para a transação

    public function __construct(Product $productModel, Estoque $estoqueModel) {
        $this->productModel = $productModel;
        $this->estoqueModel = $estoqueModel;
        // Pega a instância da conexão para controlar a transação
        $this->db = \Model\Connection::getInstance();
    }

    // O novo método, inspirado no registerClienteUser
    public function create() {
        $dadosProduto = [
            'nome' => filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_SPECIAL_CHARS),
            'preco' => filter_input(INPUT_POST, 'preco_produto', FILTER_VALIDATE_FLOAT),
            'tipo' => filter_input(INPUT_POST, 'tipo_produto', FILTER_SANITIZE_SPECIAL_CHARS),
            'descricao' => filter_input(INPUT_POST, 'descricao_produto', FILTER_SANITIZE_SPECIAL_CHARS),
            'quantidade' => filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT),
            'imagem' => (isset($_FILES['imagem_produto']) && $_FILES['imagem_produto']['error'] == UPLOAD_ERR_OK) ? file_get_contents($_FILES['imagem_produto']['tmp_name']) : null,
            'id_adm_fk' => $_SESSION['id_adm'] ?? null
        ];

        if (in_array(null, [$dadosProduto['nome'], $dadosProduto['preco'], $dadosProduto['tipo'], $dadosProduto['quantidade'], $dadosProduto['id_adm_fk']], true)) {
            $_SESSION['error_message'] = "Erro: Todos os campos obrigatórios devem ser preenchidos.";
            header('Location: cadastro_produto.php');
            exit;
        }

        try {
            $this->db->beginTransaction();

            $id_produto_criado = $this->productModel->createProduct(
                $dadosProduto['nome'], $dadosProduto['preco'], $dadosProduto['tipo'],
                $dadosProduto['descricao'], $dadosProduto['imagem'], $dadosProduto['id_adm_fk']
            );

            if (!$id_produto_criado) {
                $this->db->rollBack();
                $_SESSION['error_message'] = "Falha crítica ao salvar o produto no banco de dados.";
                header('Location: cadastro_produto.php');
                exit;
            }

            $estoqueSuccess = $this->estoqueModel->insertestoque(
                $dadosProduto['quantidade'],
                $id_produto_criado
            );

            if (!$estoqueSuccess) {
                $this->db->rollBack();
                $_SESSION['error_message'] = "Produto criado, mas falha ao registrar o estoque.";
                header('Location: cadastro_produto.php');
                exit;
            }

            $this->db->commit();
            $_SESSION['success_message'] = "Produto cadastrado com sucesso!";
            header('Location: detalhamentoAdm.php?id=' . $id_produto_criado);
            exit;

        } catch (\Exception $e) {
            $this->db->rollBack();
            $_SESSION['error_message'] = "Ocorreu um erro inesperado: " . $e->getMessage();
            header('Location: cadastro_produto.php');
            exit;
        }
    }
    

    public function update()
    {
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

    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return ['success' => false, 'errors' => ['Requisição inválida.']];
        }

        $id = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT);

        return $this->productModel->deleteProduct($id);
    }

    public function listAll()
    {
        return $this->productModel->getAllProducts();
    }

    public function findById($id)
    {
        $cleanId = filter_var($id, FILTER_VALIDATE_INT);
        return $this->productModel->getProductById($cleanId);
    }
    public function toggleFavoriteAction()
    {
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


    public function listFavorites()
    {

        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            return [];
        }

        return $this->productModel->getFavoritesByUser($userId);
    }
}
?>