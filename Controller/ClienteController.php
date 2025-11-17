<?php
namespace Controller;

require_once __DIR__ . '/../Model/Cliente.php';

use Model\Cliente;
use Exception;

class ClienteController
{
    private $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new Cliente();
    }

    public function createCliente($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente)
    {
        if (empty($nome_cliente) || empty($email_cliente) || empty($senha_cliente)) {
            return false;
        }

        return $this->clienteModel->registerClienteUser($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente);
    }

    public function checkClienteByEmail($email_cliente)
    {
        return $this->clienteModel->getClienteByEmail($email_cliente);
    }

    public function login($email_cliente, $senha_cliente)
    {
        $cliente = $this->clienteModel->getClienteByEmail($email_cliente);

        if ($cliente && password_verify($senha_cliente, $cliente['senha_cliente'])) {

            // Se usuário tem 2FA ativada, não finalize o login — marque como "pendente"
            if (!empty($cliente['2fa_enabled']) && (int)$cliente['2fa_enabled'] === 1) {
                // Armazena dados temporários na sessão para o fluxo de verificação
                $_SESSION['pending_2fa'] = true;
                $_SESSION['pending_id_cliente'] = $cliente['id_cliente'];
                $_SESSION['pending_email_cliente'] = $cliente['email_cliente'];
                return '2fa_required';
            }

            // Login normal sem 2FA
            session_regenerate_id(true);
            $_SESSION['id_cliente'] = $cliente['id_cliente'];
            $_SESSION['nome_cliente'] = $cliente['nome_cliente'];
            $_SESSION['email_cliente'] = $cliente['email_cliente'];
            $_SESSION['imagem_cliente'] = $cliente['imagem_cliente'];

            return true;
        }

        return false;
    }
    public function updateCliente($id_cliente, $nome_cliente, $email_cliente, $imagem_cliente)
    {
        if (empty($id_cliente) || empty($nome_cliente) || empty($email_cliente)) {
            return false;
        }

        // Chama o método do Model
        $success = $this->clienteModel->updateCliente($id_cliente, $nome_cliente, $email_cliente, $imagem_cliente);

        // Se a atualização foi bem-sucedida, atualiza os dados na sessão
        if ($success) {
            $_SESSION['nome_cliente'] = $nome_cliente;
            $_SESSION['email_cliente'] = $email_cliente;
            // Atualiza a imagem na sessão apenas se uma nova foi enviada
            if ($imagem_cliente !== null) {
                $_SESSION['imagem_cliente'] = $imagem_cliente;
            }
        }

        return $success;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['id_cliente']);
    }

    public function getClientData($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente)
    {
        return $this->clienteModel->getClienteInfo($nome_cliente, $email_cliente, $senha_cliente, $imagem_cliente);
    }
    public function updatePassword($id_cliente, $nova_senha, $confirmar_senha)
    {
        if (empty($id_cliente) || empty($nova_senha) || empty($confirmar_senha)) {
            $_SESSION['error_message'] = "Todos os campos de senha são obrigatórios.";
            return false;
        }
        if ($nova_senha !== $confirmar_senha) {
            $_SESSION['error_message'] = "As senhas não coincidem.";
            return false;
        }
        return $this->clienteModel->updatePassword($id_cliente, $nova_senha);
    }
    public function generate2FASecret($id_cliente, $email_cliente)
    {
        try {
            $google2fa = new \PragmaRX\Google2FAQRCode\Google2FA();
            // Gera uma nova chave secreta
            $secret = $google2fa->generateSecretKey();
            // Salva a chave secreta (ainda não ativada) no banco de dados
            $this->clienteModel->set2FASecret($id_cliente, $secret);
            // Tenta gerar o QR usando a lib instalada
            $qrCodeUrl = $google2fa->getQRCodeInline(
                'MeuManoBurger',
                $email_cliente,
                $secret
            );
            return ['success' => true, 'secret' => $secret, 'qrCodeUrl' => $qrCodeUrl];
        } catch (\PragmaRX\Google2FAQRCode\Exception\MissingQrCodeServiceException $e) {
            // Fallback: gera otpauth:// e usa Google Charts como imagem QR (temporário)
            $otpauth = 'otpauth://totp/' . rawurlencode('MeuManoBurger:' . $email_cliente) . '?secret=' . $secret . '&issuer=' . rawurlencode('MeuManoBurger');
            $qrCodeUrl = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=' . rawurlencode($otpauth);
            // salva secret mesmo que o QR local não possa ser gerado
            if (!isset($secret)) {
                // se a geração da secret falhou junto com o serviço, gere manualmente
                $google2fa = new \PragmaRX\Google2FAQRCode\Google2FA();
                $secret = $google2fa->generateSecretKey();
                $this->clienteModel->set2FASecret($id_cliente, $secret);
                $otpauth = 'otpauth://totp/' . rawurlencode('MeuManoBurger:' . $email_cliente) . '?secret=' . $secret . '&issuer=' . rawurlencode('MeuManoBurger');
                $qrCodeUrl = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=' . rawurlencode($otpauth);
            }
            return [
                'success' => true,
                'secret' => $secret,
                'qrCodeUrl' => $qrCodeUrl,
                'warning' => 'Serviço local de geração de QR não instalado. Usando fallback público (instale bacon/bacon-qr-code via Composer para gerar QR localmente).'
            ];
        } catch (\Throwable $ex) {
            return ['success' => false, 'message' => 'Erro ao gerar 2FA: ' . $ex->getMessage()];
        }
    }

// Novo método: verifica o código 2FA durante o login e conclui a sessão se válido
    public function verifyAndEnable2FA($id_cliente, $secret, $code)
    {
        $google2fa = new \PragmaRX\Google2FAQRCode\Google2FA();

        $valid = $google2fa->verifyKey($secret, $code);

        if ($valid) {
            $this->clienteModel->enable2FA($id_cliente);

            $recovery = [];
            for ($i = 0; $i < 8; $i++) {
                $recovery[] = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
            }
            $this->clienteModel->saveRecoveryCodes($id_cliente, $recovery);

            return ['success' => true, 'message' => '2FA ativado com sucesso!', 'recovery_codes' => $recovery];
        }

        return ['success' => false, 'message' => 'Código inválido. Tente novamente.'];
    }

    // verifica código TOTP ou recovery code durante login
    public function verifyLogin2FA($id_cliente, $code)
    {
        $data = $this->clienteModel->get2FAData($id_cliente);
        if (!$data) {
            return ['success' => false, 'message' => 'Dados do usuário não encontrados.'];
        }

        // se não existe secret configurado
        if (empty($data['2fa_secret']) || (int)$data['2fa_enabled'] !== 1) {
            return ['success' => false, 'message' => '2FA não configurada para este usuário.'];
        }

        try {
            $google2fa = new \PragmaRX\Google2FAQRCode\Google2FA();

            // se é um TOTP (6 dígitos numéricos) -> valida TOTP
            if (preg_match('/^\d{6}$/', $code)) {
                // pequena tolerância de window=1 (opcional)
                $valid = $google2fa->verifyKey($data['2fa_secret'], $code);
                if ($valid) {
                    $cliente = $this->clienteModel->getClienteById($id_cliente);
                    if (!$cliente) return ['success' => false, 'message' => 'Usuário inválido.'];

                    session_regenerate_id(true);
                    $_SESSION['id_cliente'] = $cliente['id_cliente'];
                    $_SESSION['nome_cliente'] = $cliente['nome_cliente'];
                    $_SESSION['email_cliente'] = $cliente['email_cliente'];
                    $_SESSION['imagem_cliente'] = $cliente['imagem_cliente'];

                    unset($_SESSION['pending_2fa'], $_SESSION['pending_id_cliente'], $_SESSION['pending_email_cliente']);

                    return ['success' => true];
                }
                return ['success' => false, 'message' => 'Código TOTP inválido.'];
            }

            // caso contrário, tenta tratar como recovery code (consumível)
            $consumed = $this->clienteModel->consumeRecoveryCode($id_cliente, $code);
            if ($consumed) {
                $cliente = $this->clienteModel->getClienteById($id_cliente);
                if (!$cliente) return ['success' => false, 'message' => 'Usuário inválido.'];

                session_regenerate_id(true);
                $_SESSION['id_cliente'] = $cliente['id_cliente'];
                $_SESSION['nome_cliente'] = $cliente['nome_cliente'];
                $_SESSION['email_cliente'] = $cliente['email_cliente'];
                $_SESSION['imagem_cliente'] = $cliente['imagem_cliente'];

                unset($_SESSION['pending_2fa'], $_SESSION['pending_id_cliente'], $_SESSION['pending_email_cliente']);

                return ['success' => true, 'message' => 'Login com recovery code bem-sucedido. Este código foi consumido.'];
            }

            return ['success' => false, 'message' => 'Código inválido.'];
        } catch (\Throwable $ex) {
            return ['success' => false, 'message' => 'Erro ao validar 2FA: ' . $ex->getMessage()];
        }
    }
    // ... (no final da classe ClienteController)

    public function disable2FA($id_cliente, $password) {
        // 1. Pega os dados atuais do usuário para verificar a senha
        $cliente = $this->clienteModel->getClienteById($id_cliente);

        if (!$cliente) {
            return ['success' => false, 'message' => 'Usuário não encontrado.'];
        }

        // 2. Verifica se a senha fornecida está correta
        if (!password_verify($password, $cliente['senha_cliente'])) {
            return ['success' => false, 'message' => 'Senha incorreta. A desativação falhou.'];
        }

        // 3. Se a senha estiver correta, chama o método do Model para desativar
        if ($this->clienteModel->disable2FA($id_cliente)) {
            return ['success' => true, 'message' => 'Autenticação de 2 Fatores desativada com sucesso!'];
        }

        return ['success' => false, 'message' => 'Ocorreu um erro ao desativar a 2FA no banco de dados.'];
    }

}


?>