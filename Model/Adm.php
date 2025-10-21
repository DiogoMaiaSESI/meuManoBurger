<?php

namespace Model;
use PDO;
use PDOException;
use Model\Connection;

class Adm
{

    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function registerAdm($nome_adm, $email_adm, $senha_adm, $imagem_adm)
    {
        try {
            $sql = "INSERT INTO Administrador (nome_adm, email_adm, senha_adm, imagem_adm)
            VALUES (:nome_adm, :email_adm, :senha_adm, :imagem_adm)";

            $hashedPassword = password_hash($senha_adm, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":nome_adm", $nome_adm, PDO::PARAM_STR);
            $stmt->bindParam(":email_adm", $email_adm, PDO::PARAM_STR);
            $stmt->bindParam(":senha_adm", $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(":imagem_adm", $imagem_adm, PDO::PARAM_LOB);

            return $stmt->execute();

        } catch (PDOException $error) {
            echo "Erro ao executar o comando " . $error->getMessage();
            return false;
        }
    }

    public function getAdmByEmail($email_adm): mixed
    {
        try {
            $sql = "SELECT * FROM Administrador WHERE  email_adm =  :email_adm LIMIT 1";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":email_adm", $email_adm, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Erro ao buscar o administrador: " . $error->getMessage();
            return false;
        }
    }

    public function getAdmInfo($id_adm, $nome_adm, $email_adm )
    {
        try {
            $sql = "SELECT nome_adm, email_adm FROM admnistrador WHERE id_adm = :id_adm AND nome_adm = :nome_adm AND email_adm = :email_adm";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":id_adm", $id_adm, PDO::PARAM_INT);
            $stmt->bindParam(":nome_adm", $nome_adm, PDO::PARAM_STR);
            $stmt->bindParam(":email_adm", $email_adm, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo "Erro ao buscar informações: " . $error->getMessage();
            return false;
        }

    }

}

?>
