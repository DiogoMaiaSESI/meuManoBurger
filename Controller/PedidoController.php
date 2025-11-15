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

    public function criarPedido ($id_produto, $id_cliente, $codigo, $qtd, $total, $retirada) {
        try {
            return $this->pedidoModel->criarPedido($id_produto, $id_cliente, $codigo, $qtd, $total, $retirada);
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
}

?>