<?php

namespace Controller;
use Model\Carrinho;
use PDOException;
use Exception;

class CarrinhoController {
    private $carrinhoModel;

    public function __construct() {
        $this->carrinhoModel = new Carrinho();
    }

    public function getAllCartProducts ($id_cliente_fk) {
        try {
            return $this->carrinhoModel->getAllCartProducts($id_cliente_fk);
        } catch (PDOException $e) {
            throw new Exception('Erro ao pegar todos os produtos do carrinho: ' . $e);
        }
    }

    public function addProductToCart ($id_produto_fk, $id_cliente_fk) {
        try {
            $produto = $this->carrinhoModel->getProductById($id_produto_fk, $id_cliente_fk);
            if (empty($produto)){
                return $this->carrinhoModel->addProductToCart($id_cliente_fk, $id_produto_fk);
            } else {
                return $this->carrinhoModel->sumOneToProduct($id_cliente_fk, $id_produto_fk);
            }
        } catch (PDOException $e) {
            throw new Exception('Erro ao adicionar produto ao carrinho: ' . $e);
        }
    }

    public function sumOneToProduct ($id_produto_fk, $id_cliente_fk) {
        try {
            return $this->carrinhoModel->sumOneToProduct($id_cliente_fk, $id_produto_fk);
        } catch (PDOException $e) {
            throw new Exception('Erro ao somar um produto: ' . $e);
        }
    }

    public function subtractOneToProduct ($id_produto_fk, $id_cliente_fk) {
        try {
            $product = $this->carrinhoModel->getProductById($id_produto_fk, $id_cliente_fk);
            if ($product['qtd_produto'] > 1) {
                return $this->carrinhoModel->subtractOneToProduct($id_cliente_fk, $id_produto_fk);
            } else {
                return $this->carrinhoModel->deleteCartProduct($id_cliente_fk, $id_produto_fk);
            }
        } catch (PDOException $e) {
            throw new Exception('Erro ao subtrair ou deletar produto: ' . $e);
        }
    }

    public function getProductById ($id_produto_fk, $id_cliente_fk) {
        try {
            return $this->carrinhoModel->getProductById($id_produto_fk, $id_cliente_fk);
        } catch (PDOException $e) {
            throw new Exception('Erro ao pegar produto pelo ID: ' . $e);
        }
    }
}

?>