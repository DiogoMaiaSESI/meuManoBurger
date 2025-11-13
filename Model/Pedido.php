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
            $pedido_existente = $this->getPedidoByCodigo($codigo);
            $id_pedido_existente = $pedido_existente['id_pedido'];
            if($id_pedido_existente===null){
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
                $stmt->bindParam(':id_pedido_fk', $id_pedido, PDO::PARAM_INT);
                $stmt->bindParam(':id_produto_fk', $id_produto, PDO::PARAM_INT);
                $stmt->bindParam(':qtd', $qtd, PDO::PARAM_INT);
                $stmt->execute();
            }else{
                $sql = 'INSERT INTO pedido_produto (id_pedido_fk, id_produto_fk, qtd) VALUES (:id_pedido_fk, :id_produto_fk, :qtd)';
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id_pedido_fk', $id_pedido_existente, PDO::PARAM_INT);
                $stmt->bindParam(':id_produto_fk', $id_produto, PDO::PARAM_INT);
                $stmt->bindParam(':qtd', $qtd, PDO::PARAM_INT);
                $stmt->execute();
            }
            return true;
        } catch (PDOException $erro) {
            throw new Exception('Erro ao criar o pedido: ' . $erro);
        }
    }
    public function getPedidoByCodigo ($codigo) {
        try{
            $sql = 'SELECT id_pedido FROM pedido WHERE codigo = :codigo';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao pegar id do pedido pelo código: ' . $e);
        }
    }
    public function getIdProdutos ($codigo){
        try{
            $pedido_existente = $this->getPedidoByCodigo($codigo);
            $id_pedido_existente = $pedido_existente['id_pedido'];
            $sql = "SELECT id_produto_fk, qtd FROM pedido_produto WHERE id_pedido_fk = :id_pedido_fk";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_pedido_fk', $id_pedido_existente, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao tentar pegar produtos pelo id do pedido: ' . $e);
        }
    }
    public function getEqualsCodigos ($codigo) {
        try{
            $sql = 'SELECT codigo FROM pedido WHERE codigo = :codigo';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao pegar códigos iguais: ' . $e);
        }
    }
}
?>