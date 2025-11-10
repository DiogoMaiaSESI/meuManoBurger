<?php

// CONFIGURAÇÕES DE USO
namespace Model;
use Model\Connection;

// IMPORTANDO A CLASSE PDO EXCEPTION PARA TRATAR ERROS DE CONEXÃO,
// OU SEJA, CASO TENHA ERROS NO BANCO DE DADOS ELE IRÁ MOSTRAR O MESMO
use PDO;
use PDOException;
use Exception;


class Estoque {

     //atributo privado criado para realizar a conexão com o banco de dados
      private $estoque;

      // construct vai automatimaticamente ser executado toda vez que necessitar da classe Estoque
      public function __construct() {
        
        //THIS ACESSA ATRIBUTOS
        // PEGUE O UNICO ATRBUTO DA CLASSE CONNECTION 
        $this->estoque = Connection::getInstance();
      }

        public function insertestoque ($qtd_produto, $id_produto_fk){
         try {

           $sql = "INSERT INTO estoque (qtd_produto, id_produto_fk) VALUES (:qtd_produto, :id_produto_fk)"; 
           //PREPARAR O BANCO DE DADOS PARA RECEBER O COMANDO ACIMA
           // ACESSANDO O BD E O PREPARANDO PARA RECEBER O COMANDO 'INSERT INTO
           $stmt = $this->estoque->prepare($sql);
           //Vincula um parâmetro ao nome da variável especificada
           $stmt->bindParam(":qtd_produto", $qtd_produto, PDO::PARAM_INT);
           $stmt->bindParam(":id_produto_fk", $id_produto_fk, PDO::PARAM_INT);
           return $stmt->execute();


        }catch(PDOException $error) {
            throw new Exception("Erro ao cadastrar produto no estoque: " . $error->getMessage());
        }
         }




    // Subtracao  do estoque com base no pedido
    public function subtracaoEstoque($id_pedido) {
        // Busca os dados do pedido
        $pedido = $this->getQuantidadePedido($id_pedido);
        if (!$pedido) return "Pedido não encontrado.";

        $id_produto = $pedido['id_produto_fk'];
        $qtd_pedido = $pedido['qtd'];

        // Busca o estoque do produto
        $estoque = $this->getEstoque($id_produto);
        if (!$estoque) return "Produto não encontrado no estoque.";

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
        private function getQuantidadePedido($id_pedido) {
        $sql = "SELECT id_produto_fk, qtd FROM pedidos WHERE id_pedido = ?";
        $stmt = $this->estoque->prepare($sql);
        $stmt->execute([$id_pedido]);
         return $stmt->fetch(PDO::FETCH_ASSOC);
        }





        //estoque atual do produto
       public function getEstoque($id_produto_fk) {
        $sql = "SELECT * FROM estoque WHERE id_produto_fk = ?";
        $stmt = $this->estoque->prepare($sql);
        $stmt->execute([$id_produto_fk]);

        //PDO::FETCH_ASSOC retorna apenas um único valor por nome de coluna.
       //FETCH_ASSOC TRANSFORMA OS DADOS EM UM ARRAY ASSOCIATIVO E RETORNA ESSES DADOS NA TELA.
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




            //atualizando o estoque do produto
            public function atualizarEstoque($new_qtd, $id_produto_fk) {
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



}




 ?>
