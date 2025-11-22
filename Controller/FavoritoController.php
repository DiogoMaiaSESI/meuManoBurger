<?php


namespace Controller;
require_once __DIR__ . "/../Model/Favorito.php";
use Model\Favorito;
use PDOException;
use Exception;

class FavoritoController {
    private $favoritoModel;

    public function __construct() {
        $this->favoritoModel = new Favorito();
    }

    public function getAllFavoritesByClient ($id_cliente) {
        try {
            return $this->favoritoModel->getAllFavoritesByClient($id_cliente);
        } catch (PDOException $e) {
            throw new Exception('Erro ao pegar favoritos pelo id do cliente: ' . $e);
        }
    }

    public function createFavorite ($id_produto, $id_cliente) {
        try {
            return $this->favoritoModel->createFavorite($id_produto, $id_cliente);
        } catch (PDOException $e) {
            throw new Exception('Erro ao inserir favorito: ' . $e);
        }
    }
    
    public function deleteFavorite ($id_produto, $id_cliente) {
        try {
            return $this->favoritoModel->deleteFavorite($id_produto, $id_cliente);
        } catch (PDOException $e) {
            throw new Exception('Erro ao deletar favorito: ' . $e);
        }
    }

    public function getSingleProduct ($id_cliente, $id_produto) {
        try {
            return $this->favoritoModel->getSingleProduct($id_cliente, $id_produto);
        } catch (PDOException $e) {
            throw new Exception('Erro ao selecionar produto específico: ' . $e);
        }
    }
}

?>