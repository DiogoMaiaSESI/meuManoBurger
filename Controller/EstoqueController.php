<?php

namespace Controller;
require_once __DIR__ . "/../Model/Connection.php";
require_once __DIR__ . "/../Model/Estoque.php";

//conexão com a tabela do estoque
use Model\Estoque;


//Erros em Geral
use Exception;



class EstoqueController {

     //atributo privado criado para realizar a conexão com a tabela do estoque
    private $estoqueModel;

    public function __construct() {
        $this->estoqueModel = new Estoque();
    }

    // Função para inserir no estoque
    public function insEstoque($qtd_produto, $id_produto_fk) {
        try {
            return $this->estoqueModel->insertestoque($qtd_produto, $id_produto_fk);
        } catch (Exception $e) {
            return "Erro ao adicionar no estoque: " . $e->getMessage();
        }
    }

    //Função para reduzir o estoque com base no pedido
    public function subEstoque($id_pedido) {
        try {
            return $this->estoqueModel->subtracaoEstoque($id_pedido);
        } catch (Exception $e) {
            return "Erro ao reduzir estoque: " . $e->getMessage();
        }
    }


    // Função para atualizar o estoque
public function atEstoque($id_produto_fk, $new_qtd) {
    try {
        return $this->estoqueModel->atualizarEstoque($id_produto_fk, $new_qtd); 
    } catch (Exception $e) {
        return "Erro ao atualizar estoque: " . $e->getMessage();
    }
}

//Função para obter o estoque de um produto
public function obtEstoque($id_produto_fk) {
    try {
        return $this->estoqueModel->getEstoque($id_produto_fk);
    } catch (Exception $e) {
        return "Erro ao obter estoque: " . $e->getMessage();
    }
}

}


?>