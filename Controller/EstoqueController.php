<?php

namespace Controller;

use Model\Estoque;
use Exception;

// Importa model
require_once __DIR__ . "/../Model/Estoque.php";

class EstoqueController
{
    private $estoqueModel;

    public function __construct()
    {
        $this->estoqueModel = new Estoque();
    }

    // -------------------------------------------------
    // INSERIR NO ESTOQUE
    // -------------------------------------------------
    public function insEstoque($qtd_produto, $id_produto_fk)
    {
        try {
            return $this->estoqueModel->insertestoque($qtd_produto, $id_produto_fk);
        } catch (Exception $e) {
            return "Erro ao adicionar no estoque: " . $e->getMessage();
        }
    }

    // -------------------------------------------------
    // SUBTRAIR ESTOQUE COM BASE EM PEDIDO
    // -------------------------------------------------
    public function subEstoque($id_pedido)
    {
        try {
            return $this->estoqueModel->subtracaoEstoque($id_pedido);
        } catch (Exception $e) {
            return "Erro ao reduzir estoque: " . $e->getMessage();
        }
    }

    // -------------------------------------------------
    // ATUALIZAR ESTOQUE
    // -------------------------------------------------
    public function atEstoque($id_produto_fk, $new_qtd)
    {
        try {
            return $this->estoqueModel->atualizarEstoque($id_produto_fk, $new_qtd);
        } catch (Exception $e) {
            return "Erro ao atualizar estoque: " . $e->getMessage();
        }
    }

    // -------------------------------------------------
    // OBTER ESTOQUE DE UM PRODUTO
    // -------------------------------------------------
    public function obtEstoque($id_produto_fk)
    {
        try {
            return $this->estoqueModel->getEstoque($id_produto_fk);
        } catch (Exception $e) {
            return "Erro ao obter estoque: " . $e->getMessage();
        }
    }
}

?>
