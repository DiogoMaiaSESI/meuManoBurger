<?php

namespace Model;

use Model\Connection;
use PDO;
use PDOException;

// Importa a Connection
require_once __DIR__ . '/../Model/Connection.php';

class Estoque
{
    private $estoque;

    public function __construct()
    {
        $this->estoque = Connection::getInstance();
    }

    // ------------------------
    // INSERIR NO ESTOQUE
    // ------------------------
    public function insertestoque($qtd_produto, $id_produto_fk)
    {
        try {
            $sql = "INSERT INTO estoque (qtd_produto, id_produto_fk) 
                    VALUES (:qtd_produto, :id_produto_fk)";
            $stmt = $this->estoque->prepare($sql);
            $stmt->bindParam(":qtd_produto", $qtd_produto, PDO::PARAM_INT);
            $stmt->bindParam(":id_produto_fk", $id_produto_fk, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $error) {
            error_log("Erro no Model/Estoque.insertestoque: " . $error->getMessage());
            return false;
        }
    }

    // ------------------------
    // REDUZ ESTOQUE BASEADO EM PEDIDO
    // ------------------------
    public function subtracaoEstoque($id_pedido)
    {
        try {
            $produtos = $this->getQuantidadePedido($id_pedido);
            if (!$produtos || count($produtos) === 0) {
                return "Pedido não encontrado.";
            }

            foreach ($produtos as $produto) {

                $id_produto = $produto['id_produto_fk'];
                $qtd_pedido = $produto['qtd'];

                $estoque = $this->getEstoque($id_produto);
                if (!$estoque) return "Produto não encontrado no estoque.";

                $qtd_estoque = $estoque['qtd_produto'];

                if ($qtd_estoque < $qtd_pedido) {
                    return "Estoque insuficiente: disponível $qtd_estoque, pedido $qtd_pedido.";
                }

                $novo_estoque = $qtd_estoque - $qtd_pedido;

                $update = $this->estoque->prepare("
                    UPDATE estoque 
                    SET qtd_produto = :novo
                    WHERE id_produto_fk = :id_produto
                ");
                $update->bindParam(":novo", $novo_estoque, PDO::PARAM_INT);
                $update->bindParam(":id_produto", $id_produto, PDO::PARAM_INT);
                $update->execute();
            }

            return "Pedido processado com sucesso.";

        } catch (PDOException $e) {
            error_log("Erro no Model/Estoque.subtracaoEstoque: " . $e->getMessage());
            return false;
        }
    }

    // ------------------------
    // BUSCA QUANTIDADE DO PEDIDO
    // ------------------------
    private function getQuantidadePedido($id_pedido)
    {
        try {
            $sql = "SELECT id_produto_fk, qtd 
                    FROM pedido_produto 
                    WHERE id_pedido_fk = ?";
            $stmt = $this->estoque->prepare($sql);
            $stmt->execute([$id_pedido]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Erro no Model/Estoque.getQuantidadePedido: " . $e->getMessage());
            return false;
        }
    }

    // ------------------------
    // BUSCAR ESTOQUE DE UM PRODUTO
    // ------------------------
    public function getEstoque($id_produto_fk)
    {
        try {
            $sql = "SELECT * FROM estoque WHERE id_produto_fk = :id";
            $stmt = $this->estoque->prepare($sql);
            $stmt->bindParam(":id", $id_produto_fk, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Erro ao obter estoque: " . $e->getMessage());
            return false;
        }
    }

    // ------------------------
    // ATUALIZAR ESTOQUE
    // ------------------------
    public function atualizarEstoque($id_produto_fk, $new_qtd)
    {
        try {
            $sql = "UPDATE estoque 
                    SET qtd_produto = :new_qtd 
                    WHERE id_produto_fk = :id_produto_fk";
            $stmt = $this->estoque->prepare($sql);

            $stmt->bindParam(":new_qtd", $new_qtd, PDO::PARAM_INT);
            $stmt->bindParam(":id_produto_fk", $id_produto_fk, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $error) {
            error_log("Erro ao atualizar estoque: " . $error->getMessage());
            return false;
        }
    }

    // ------------------------
    // DELETAR ESTOQUE
    // ------------------------
    public function deleteEstoque($id_produto_fk)
    {
        try {
            $sql = "DELETE FROM estoque WHERE id_produto_fk = :id";
            $stmt = $this->estoque->prepare($sql);
            $stmt->bindParam(":id", $id_produto_fk, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Erro ao deletar estoque: " . $e->getMessage());
            return false;
        }
    }
}

?>
