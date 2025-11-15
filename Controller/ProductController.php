<?php

namespace Controller;

use Exception;
use PDOException;
use Model\Product;
use Model\Estoque;

class ProductController
{
    private $productModel;
    private $estoqueModel;
    private $db; // Conexão para a transação

    public function __construct(Product $productModel, Estoque $estoqueModel)
    {
        $this->productModel = $productModel;
        $this->estoqueModel = $estoqueModel;
        // Pega a instância da conexão para controlar a transação
        $this->db = \Model\Connection::getInstance();
    }

    // O novo método, inspirado no registerClienteUser
    public function create()
    {
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
                $dadosProduto['nome'],
                $dadosProduto['preco'],
                $dadosProduto['tipo'],
                $dadosProduto['descricao'],
                $dadosProduto['imagem'],
                $dadosProduto['id_adm_fk']
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
            return ['success' => false, 'message' => 'Requisição inválida.'];
        }

        $id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT);
        $nome = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_SPECIAL_CHARS);
        $preco = filter_input(INPUT_POST, 'preco_produto', FILTER_VALIDATE_FLOAT);
        $tipo = filter_input(INPUT_POST, 'tipo_produto', FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = filter_input(INPUT_POST, 'descricao_produto', FILTER_SANITIZE_SPECIAL_CHARS);
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $id_adm_fk = $_SESSION['id_adm'];

        if (!$id_produto || !$nome || $preco === false || !$tipo || $quantidade === false) {
            return ['success' => false, 'message' => 'Dados inválidos ou faltando. Verifique os campos.'];
        }

        // [CORREÇÃO] Lógica explícita para a imagem
        $imagem_conteudo = null;
        $atualizar_imagem = false;
        if (isset($_FILES['imagem_produto']) && $_FILES['imagem_produto']['error'] == UPLOAD_ERR_OK) {
            $imagem_conteudo = file_get_contents($_FILES['imagem_produto']['tmp_name']);
            $atualizar_imagem = true; // Sinaliza que uma nova imagem foi enviada.
        }

        try {
            $this->db->beginTransaction();

            // 1. Atualiza a tabela 'produto'
            $productUpdateResult = $this->productModel->updateProduct(
                $id_produto,
                $nome,
                $preco,
                $tipo,
                $descricao,
                $imagem_conteudo,
                $atualizar_imagem,
                $id_adm_fk
            );
            if (!$productUpdateResult['success']) {
                $this->db->rollBack();
                return ['success' => false, 'message' => 'Erro ao atualizar os dados do produto.'];
            }

            // 2. Atualiza a tabela 'estoque'
            $estoqueController = new \Controller\EstoqueController();
            $estoqueUpdateResult = $estoqueController->atEstoque($id_produto, $quantidade);
            if (!$estoqueUpdateResult) {
                $this->db->rollBack();
                return ['success' => false, 'message' => 'Erro ao atualizar a quantidade em estoque.'];
            }

            $this->db->commit();
            return ['success' => true];

        } catch (\Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'message' => 'Erro inesperado no servidor: ' . $e->getMessage()];
        }
    }

    public function delete()
    {
        // [CORREÇÃO] Verifica se a requisição é POST.
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return ['success' => false, 'message' => 'Requisição inválida.'];
        }

        // [CORREÇÃO] Lê o corpo JSON da requisição.
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        $id_produto = filter_var($data['id_produto'] ?? null, FILTER_VALIDATE_INT);

        if (!$id_produto) {
            return ['success' => false, 'message' => 'ID do produto inválido ou não fornecido.'];
        }

        try {
            $this->db->beginTransaction();

            // 1. Deleta da tabela 'estoque' primeiro (por causa da chave estrangeira)
            $estoqueModel = new \Model\Estoque();
            $estoqueDeleteResult = $estoqueModel->deleteEstoque($id_produto);
            if (!$estoqueDeleteResult) {
                // Não tratamos como erro fatal, pois o estoque pode não existir.
                // Apenas logamos se necessário.
            }

            // 2. Deleta da tabela 'produto'
            $productDeleteResult = $this->productModel->deleteProduct($id_produto);
            if (!$productDeleteResult['success']) {
                $this->db->rollBack();
                return ['success' => false, 'message' => 'Erro ao deletar o produto principal.'];
            }

            $this->db->commit();
            return ['success' => true];

        } catch (\Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'message' => 'Erro inesperado no servidor: ' . $e->getMessage()];
        }
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
        // [CORREÇÃO] Lê o ID do produto do POST, que é como o front-end envia.
        $productId = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT);

        if (!$userId) {
            return ['success' => false, 'errors' => ['Você precisa estar logado para gerenciar favoritos.']];
        }
        if (!$productId) {
            return ['success' => false, 'errors' => ['ID do produto inválido.']];
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

    public function getProductsByType($type)
    {
        try {
            $sanitizedType = filter_var($type, FILTER_SANITIZE_SPECIAL_CHARS);
            return $this->productModel->getProductsByType($sanitizedType);
        } catch (PDOException $e) { // O 'use PDOException' no topo do arquivo resolve o erro.
            throw new Exception('Erro ao selecionar produtos pelo tipo: ' . $e->getMessage());
        }
    }
}
?>