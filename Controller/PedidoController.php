<?php

namespace Controller;
use Exception;
use Model\Pedido;
use PDOException;

class PedidoController {
    private $pedidoModel;

    public function __construct() {
        $this->pedidoModel = new Pedido();
    }

    public function criarPedido ($id_produto, $id_cliente, $codigo, $qtd, $total, $retirada, $status) {
        try {
            return $this->pedidoModel->criarPedido($id_produto, $id_cliente, $codigo, $qtd, $total, $retirada, $status);
        } catch (PDOException $e) {
            throw new PDOException("Erro ao criar pedido: " . $e->getMessage());
        }
    }

    public function getPedidoByCodigo ($codigo) {
        try {
            return $this->pedidoModel->getEqualsCodigos($codigo);
        } catch (PDOException $e) {
            throw new PDOException("Erro ao obter pedido pelo código: " . $e->getMessage());
        }
    }
    public function getAllPedidos () {
        try {
            return $this->pedidoModel->getAllPedidos();
        } catch (PDOException $e) {
            throw new Exception('Erro ao tentar pegar todos os pedidos: ' . $e);
        }
    }
    public function getIdPedidoByCodigo ($codigo) {
        try {
            return $this->pedidoModel->getPedidoByCodigo($codigo);
        } catch (PDOException $e) {
            throw new Exception('Erro ao pegar id do pedido: ' . $e);
        }
    }
    public function getPedidoProdutoById ($id) {
        try {
            return $this->pedidoModel->getPedidoProdutoById($id);
        } catch (PDOException $e) {
            throw new Exception('Erro ao pegar pedido_produto: ' . $e);
        }
    }

    public function updateStatusPedido ($codigo, $status) {
        try {
            return $this->pedidoModel->updateStatusPedido($codigo, $status);
        } catch (PDOException $e) {
            throw new Exception('Erro ao atualizar status do pedido: ' . $e);
        }
    }
}

?>