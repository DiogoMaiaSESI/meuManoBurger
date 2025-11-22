<?php

namespace Controller;
require_once __DIR__ . "/../Model/Product.php";
require_once __DIR__ . "/../Model/Estoque.php";
use Exception;
use PDOException;
use Model\Product;
use Model\Estoque;

class ProductController
{
    private $productModel;
    private $estoqueModel;
    private $db; // Conexão para a transação

    public function __construct()
    {
        $this->productModel = new Product();
        $this->estoqueModel = new Estoque();
        // Pega a instância da conexão para controlar a transação
        $this->db = \Model\Connection::getInstance();
    }

    // Cria produto + estoque em transação
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
            $_SESSION['product_id'] = $id_produto_criado;
            header('Location: detalhamentoAdm.php?id=' . $id_produto_criado);
            exit;

        } catch (Exception $e) {
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
        
        $id_adm_fk = $_SESSION['id_adm'] ?? null;

        if (!$id_produto || !$nome || $preco === false || !$tipo || $quantidade === false) {
            return ['success' => false, 'message' => 'Dados inválidos ou faltando. Verifique os campos.'];
        }

        // Lógica explícita para a imagem
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





        } catch (Exception $e) {


            $this->db->rollBack();


            return ['success' => false, 'message' => 'Erro inesperado no servidor: ' . $e->getMessage()];


        }
    }

    public function delete()
{
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        return ['success' => false, 'message' => 'Requisição inválida.'];
    }

    // [A CORREÇÃO] Lê o ID do produto a partir do $_POST.
    $id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT);

    if (!$id_produto) {
        return ['success' => false, 'message' => 'ID do produto inválido ou não fornecido.'];
    }

    // O resto da sua lógica de transação para deletar continua igual...
    try {
        $this->db->beginTransaction();
        $estoqueModel = new Estoque();
        $estoqueModel->deleteEstoque($id_produto);
        $this->productModel->deleteProduct($id_produto);
        $this->db->commit();
        return ['success' => true];
    } catch (exception $e) {
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

    public function getProductsByType($type)
    {
        try {
            $sanitizedType = filter_var($type, FILTER_SANITIZE_SPECIAL_CHARS);
            return $this->productModel->getProductsByType($sanitizedType);
        } catch (PDOException $e) {
            throw new Exception('Erro ao selecionar produtos pelo tipo: ' . $e->getMessage());
        }
    }
}
?>
