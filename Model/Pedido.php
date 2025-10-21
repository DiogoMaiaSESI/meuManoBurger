<?php
namespace Model;
use Exception;
use Model\Connection;

use PDO;
use PDOException;
class Pedido {
    private $db;
    public function __construct() {
        $this->db = Connection::getInstance();
    }
    public function criarPedido ($id_produto, $id_cliente, $codigo, $id_estoque, $qtd) {
        try {
            $sql = 'INSERT INTO pedido (codigo, id_cliente_fk, id_estoque_fk) VALUES (:codigo, :id_cliente_fk, :id_estoque_fk)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->bindParam(':id_cliente_fk', $id_cliente, PDO::PARAM_INT);
            $stmt->bindParam(':id_estoque_fk', $id_estoque, PDO::PARAM_INT);
            $stmt->execute();

            $sql = 'SELECT id_pedido FROM pedido ORDER BY id_pedido DESC LIMIT 1';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_pedido = $pedido['id_pedido'];

            $sql = 'INSERT INTO pedido_produto (id_pedido_fk, id_produto_fk, qtd) VALUES (:id_pedido_fk, :id_produto_fk, :qtd)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_pedido_fk', $id_pedido, PDO::FETCH_ASSOC);
            $stmt->bindParam(':id_produto_fk', $id_produto, PDO::FETCH_ASSOC);
            $stmt->bindParam(':qtd', $qtd, PDO::FETCH_ASSOC);
            $stmt->execute();

        } catch (PDOException $erro) {
            throw new Exception('Erro ao criar o pedido: ' . $erro);
        }
    }
}

?>