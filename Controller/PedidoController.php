<?php

namespace Controller;
use Model\Pedido;
use PDOException;

class PedidoController {
    private $pedidoModel;

    public function __construct() {
        $this->pedidoModel = new Pedido();
    }

    public function criarPedido ($id_produto, $id_cliente, $codigo, $qtd, $total) {
        try {
            return $this->pedidoModel->criarPedido($id_produto, $id_cliente, $codigo, $qtd, $total);
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
}

?>