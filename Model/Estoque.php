<?php

// CONFIGURAÇÕES DE USO
namespace Model;
use Model\Connection;
require_once __DIR__ . '/../Model/Connection.php';

// IMPORTANDO A CLASSE PDO EXCEPTION PARA TRATAR ERROS DE CONEXÃO,
// OU SEJA, CASO TENHA ERROS NO BANCO DE DADOS ELE IRÁ MOSTRAR O MESMO
use PDO;
use PDOException;
use Exception;


class Estoque
{

    //atributo privado criado para realizar a conexão com o banco de dados
    private $estoque;

    // construct vai automatimaticamente ser executado toda vez que necessitar da classe Estoque
    public function __construct()
    {

        //THIS ACESSA ATRIBUTOS
        // PEGUE O UNICO ATRBUTO DA CLASSE CONNECTION 
        $this->estoque = Connection::getInstance();
    }

    public function insertestoque($qtd_produto, $id_produto_fk)
{
    try {
        $sql = "INSERT INTO estoque (qtd_produto, id_produto_fk) VALUES (:qtd_produto, :id_produto_fk)";
        $stmt = $this->estoque->prepare($sql);
        $stmt->bindParam(":qtd_produto", $qtd_produto, PDO::PARAM_INT);
        $stmt->bindParam(":id_produto_fk", $id_produto_fk, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $error) {
        error_log("Erro no Model/Estoque: " . $error->getMessage());
        return false;
    }
}




    // Subtracao  do estoque com base no pedido
    public function subtracaoEstoque($id_pedido)
    {
        // Busca os dados do pedido
        $pedido = $this->getQuantidadePedido($id_pedido);
        if (!$pedido)
            return "Pedido não encontrado.";

        $id_produto = $pedido['id_produto_fk'];
        $qtd_pedido = $pedido['qtd'];

        // Busca o estoque do produto
        $estoque = $this->getEstoque($id_produto);
        if (!$estoque)
            return "Produto não encontrado no estoque.";

        $qtd_estoque = $estoque['qtd_produto'];

        // Verifica se há estoque suficiente
        if ($qtd_estoque < $qtd_pedido) {
            return "Estoque insuficiente: disponível $qtd_estoque, pedido $qtd_pedido.";
        }

        // Faz a subtração
        $novo_estoque = $qtd_estoque - $qtd_pedido;

        // Atualiza a tabela estoque
        $update = $this->estoque->prepare("UPDATE estoque SET qtd_produto = ? WHERE id_produto_fk = ?");
        $update->execute([$novo_estoque, $id_produto]);

        return "Pedido processado. Estoque atualizado de $qtd_estoque para $novo_estoque.";
    }

    // Função para obter a quantidade do pedido
    private function getQuantidadePedido($id_pedido)
    {
        $sql = "SELECT id_produto_fk, qtd FROM pedidos WHERE id_pedido = ?";
        $stmt = $this->estoque->prepare($sql);
        $stmt->execute([$id_pedido]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





    //estoque atual do produto
    public function getEstoque($id_produto_fk) {
    try {
        $sql = "SELECT * FROM estoque WHERE id_produto_fk = :id_produto_fk";
        $stmt = $this->estoque->prepare($sql);
        // Use bindParam para mais clareza
        $stmt->bindParam(":id_produto_fk", $id_produto_fk, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        // Em caso de erro de banco de dados, logue o erro e retorne false.
        // Nunca dê "echo" ou "die" em um Model.
        error_log("Erro ao obter estoque: " . $e->getMessage());
        return false;
    }
}




    //atualizando o estoque do produto
    public function atualizarEstoque($new_qtd, $id_produto_fk)
    {
        try {
            $sql = "UPDATE estoque SET qtd_produto = :new_qtd WHERE id_produto_fk = :id_produto_fk";
            $stmt = $this->estoque->prepare($sql);
            $stmt->bindParam(":new_qtd", $new_qtd, PDO::PARAM_INT);
            $stmt->bindParam(":id_produto_fk", $id_produto_fk, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $error) {
            throw new Exception("Erro ao atualizar estoque: " . $error->getMessage());

        }

    }
    public function deleteEstoque($id_produto_fk) {
    try {
        $sql = "DELETE FROM estoque WHERE id_produto_fk = :id_produto_fk";
        $stmt = $this->estoque->prepare($sql);
        $stmt->bindParam(":id_produto_fk", $id_produto_fk, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Erro ao deletar estoque: " . $e->getMessage());
        return false;
    }
}



}




?>