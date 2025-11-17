<?php
namespace Model;

require_once __DIR__ . '/../Model/Connection.php';

use PDO;
use PDOException;

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
            $sql = "INSERT INTO administrador (nome_adm, email_adm, senha_adm, imagem_adm)
            VALUES (:nome_adm, :email_adm, :senha_adm, :imagem_adm)";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":nome_adm", $nome_adm, PDO::PARAM_STR);
            $stmt->bindParam(":email_adm", $email_adm, PDO::PARAM_STR);
            $stmt->bindParam(":senha_adm", $senha_adm, PDO::PARAM_STR);
            $stmt->bindParam(":imagem_adm", $imagem_adm, PDO::PARAM_LOB);

            return $stmt->execute();
        } catch (PDOException $error) {
            // Em produção, logar o erro em vez de dar echo.
            error_log("Erro ao registrar ADM: " . $error->getMessage());
            return false;
        }
    }

    public function getAdmByEmail($email_adm)
    {
        try {
            $sql = "SELECT * FROM administrador WHERE email_adm = :email_adm LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email_adm", $email_adm, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            error_log("Erro ao buscar ADM por e-mail: " . $error->getMessage());
            return false;
        }
    }

    public function getAdmById($id_adm)
    {
        try {
            $sql = 'SELECT * FROM administrador WHERE id_adm = :id_adm LIMIT 1';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_adm", $id_adm, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            error_log("Erro ao buscar ADM por ID: " . $error->getMessage());
            return false;
        }
    }

    public function updateAdm($id_adm, $nome_adm, $email_adm, $imagem_adm)
    {
        try {
            $sql = 'UPDATE administrador SET nome_adm = :nome_adm, email_adm = :email_adm';
            if ($imagem_adm !== null) {
                $sql .= ', imagem_adm = :imagem_adm';
            }
            $sql .= ' WHERE id_adm = :id_adm';

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_adm", $id_adm, PDO::PARAM_INT);
            $stmt->bindParam(":nome_adm", $nome_adm, PDO::PARAM_STR);
            $stmt->bindParam(":email_adm", $email_adm, PDO::PARAM_STR);

            if ($imagem_adm !== null) {
                $stmt->bindParam(":imagem_adm", $imagem_adm, PDO::PARAM_LOB);
            }
            return $stmt->execute();
        } catch (PDOException $error) {
            error_log("Erro ao atualizar ADM: " . $error->getMessage());
            return false;
        }
    }

    public function updatePassword($id_adm, $nova_senha)
    {
        try {
            $hashedPassword = password_hash($nova_senha, PASSWORD_DEFAULT);
            $sql = 'UPDATE administrador SET senha_adm = :senha_adm WHERE id_adm = :id_adm';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":senha_adm", $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(":id_adm", $id_adm, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $error) {
            error_log("Erro ao atualizar senha do ADM: " . $error->getMessage());
            return false;
        }
    }

    // --- MÉTODOS DE 2FA CORRIGIDOS ---

    public function set2FASecret($id_adm, $secret) {
        $sql = 'UPDATE administrador SET 2fa_secret = :secret, 2fa_enabled = 0 WHERE id_adm = :id_adm';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':secret', $secret, PDO::PARAM_STR);
        $stmt->bindParam(':id_adm', $id_adm, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function enable2FA($id_adm) {
        $sql = 'UPDATE administrador SET 2fa_enabled = 1 WHERE id_adm = :id_adm';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_adm', $id_adm, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function disable2FA($id_adm) {
        $sql = 'UPDATE administrador SET 2fa_secret = NULL, 2fa_enabled = 0, 2fa_recovery = NULL WHERE id_adm = :id_adm';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_adm', $id_adm, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function get2FAData($id_adm) {
        $sql = 'SELECT 2fa_secret, 2fa_enabled FROM administrador WHERE id_adm = :id_adm LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_adm", $id_adm, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
