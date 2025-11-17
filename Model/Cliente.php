<?php

namespace Model;

require_once __DIR__ . '/../Model/Connection.php';

use Model\Connection;
use PDO;
use PDOException;
use Exception;

class Cliente
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function registerClienteUser($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente)
    {
        try {
            $sql = 'INSERT INTO cliente(nome_cliente, email_cliente, senha_cliente, imagem_cliente) VALUES (:nome_cliente, :email_cliente, :senha_cliente, :imagem_cliente)';

            $hashedPassword = password_hash($senha_cliente, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":nome_cliente", $nome_cliente, PDO::PARAM_STR);
            $stmt->bindParam(":email_cliente", $email_cliente, PDO::PARAM_STR);
            $stmt->bindParam(":senha_cliente", $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(":imagem_cliente", $imagem_cliente, PDO::PARAM_LOB);

            return $stmt->execute();
        } catch (PDOException $error) {
            echo "Erro ao executar comando:  " . $error->getMessage();
            return false;
        }
    }

    public function getClienteByEmail($email_cliente)
    {
        try {
            $sql = 'SELECT * FROM cliente WHERE email_cliente = :email_cliente LIMIT 1';

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":email_cliente", $email_cliente, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo "Erro ao resgatar usuário pelo email: " . $error->getMessage();
            return false;
        }
    }

    public function getClienteInfo($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente)
    {
        try {
            $sql = 'SELECT * FROM cliente WHERE nome_cliente = :nome_cliente AND email_cliente = :email_cliente AND senha_cliente = :senha_cliente AND imagem_cliente = :imagem_cliente LIMIT 1';

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":nome_cliente", $nome_cliente, PDO::PARAM_STR);
            $stmt->bindParam(":email_cliente", $email_cliente, PDO::PARAM_STR);
            $stmt->bindParam(":senha_cliente", $senha_cliente, PDO::PARAM_STR);
            $stmt->bindParam(":imagem_cliente", $imagem_cliente, PDO::PARAM_LOB);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo "Erro ao resgatar usuário pelas informações: " . $error->getMessage();
            return false;
        }
    }
    public function updateCliente($id_cliente, $nome_cliente, $email_cliente, $imagem_cliente)
    {
        try {
            $sql = 'UPDATE cliente SET nome_cliente = :nome_cliente, email_cliente = :email_cliente';

            if ($imagem_cliente !== null) {
                $sql .= ', imagem_cliente = :imagem_cliente';
            }

            $sql .= ' WHERE id_cliente = :id_cliente';

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
            $stmt->bindParam(":nome_cliente", $nome_cliente, PDO::PARAM_STR);
            $stmt->bindParam(":email_cliente", $email_cliente, PDO::PARAM_STR);

            // Faz o bind da imagem APENAS se ela existir
            if ($imagem_cliente !== null) {
                $stmt->bindParam(":imagem_cliente", $imagem_cliente, PDO::PARAM_LOB);
            }


            return $stmt->execute();

        } catch (PDOException $error) {
            echo "Erro ao atualizar cliente: " . $error->getMessage();
            return false;
        }
    }
    public function updatePassword($id_cliente, $nova_senha)
    {
        try {
            // Criptografa a nova senha antes de salvar
            $hashedPassword = password_hash($nova_senha, PASSWORD_DEFAULT);

            $sql = 'UPDATE cliente SET senha_cliente = :senha_cliente WHERE id_cliente = :id_cliente';

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":senha_cliente", $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);


            return $stmt->execute();

        } catch (PDOException $error) {
            return false;
        }
    }

    public function set2FASecret($id_cliente, $secret) {
        $sql = 'UPDATE cliente SET 2fa_secret = :secret, 2fa_enabled = 0 WHERE id_cliente = :id_cliente';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':secret', $secret, PDO::PARAM_STR);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function enable2FA($id_cliente) {
        $sql = 'UPDATE cliente SET 2fa_enabled = 1 WHERE id_cliente = :id_cliente';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getClienteById($id_cliente)
    {
        try {
            $sql = 'SELECT * FROM cliente WHERE id_cliente = :id_cliente LIMIT 1';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            return false;
        }
    }

    public function get2FAData($id_cliente)
    {
        try {
            $sql = 'SELECT 2fa_secret, 2fa_enabled FROM cliente WHERE id_cliente = :id_cliente LIMIT 1';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            return false;
        }
    }
    public function saveRecoveryCodes($id_cliente, array $codes)
    {
        try {
            // armazena array de hashes em JSON
            $hashes = array_map(function($c){ return password_hash($c, PASSWORD_DEFAULT); }, $codes);
            $json = json_encode($hashes);
            $sql = 'UPDATE cliente SET 2fa_recovery = :recovery WHERE id_cliente = :id_cliente';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':recovery', $json, PDO::PARAM_STR);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getRecoveryHashes($id_cliente)
    {
        try {
            $sql = 'SELECT 2fa_recovery FROM cliente WHERE id_cliente = :id_cliente LIMIT 1';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row || empty($row['2fa_recovery'])) return [];
            $decoded = json_decode($row['2fa_recovery'], true);
            return is_array($decoded) ? $decoded : [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function consumeRecoveryCode($id_cliente, $code)
    {
        try {
            $hashes = $this->getRecoveryHashes($id_cliente);
            if (empty($hashes)) return false;

            $foundIndex = null;
            foreach ($hashes as $i => $hash) {
                if (password_verify($code, $hash)) {
                    $foundIndex = $i;
                    break;
                }
            }
            if ($foundIndex === null) return false;

            // remove o código usado e salva novamente
            array_splice($hashes, $foundIndex, 1);
            $json = json_encode($hashes);
            $sql = 'UPDATE cliente SET 2fa_recovery = :recovery WHERE id_cliente = :id_cliente';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':recovery', $json, PDO::PARAM_STR);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function disable2FA($id_cliente) {
        try {
            // Limpa o segredo, os códigos de recuperação e desativa a flag
            $sql = 'UPDATE cliente SET 2fa_secret = NULL, 2fa_enabled = 0, 2fa_recovery = NULL WHERE id_cliente = :id_cliente';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Em um ambiente real, você logaria o erro
            return false;
        }
    }

}
?>