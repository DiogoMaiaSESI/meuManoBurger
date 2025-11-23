<?php
namespace Controller;

require_once __DIR__ . '/../Model/Feedback.php';
use Model\Feedback;

class FeedbackController {
    private $feedbackModel;

    public function __construct(Feedback $feedbackModel) {
        $this->feedbackModel = $feedbackModel;
    }

    public function Create() {
        // 1. Segurança: Só continua se for um POST e se o cliente estiver logado.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['id_cliente'])) {
            $_SESSION['error_message'] = 'Acesso negado.';
            header('Location: paginaPrincipalUser.php');
            exit;
        }

        // 2. Pega e limpa os dados do formulário
        $descricao = filter_input(INPUT_POST, 'descricao_feedback', FILTER_SANITIZE_SPECIAL_CHARS);
        $idCliente = $_SESSION['id_cliente'];

        // 3. Validação: Garante que a descrição não está vazia.
        if (empty(trim($descricao))) {
            $_SESSION['error_message'] = 'O campo de feedback não pode estar vazio.';
            header('Location: paginaPrincipalUser.php#feedback'); // Volta para a seção de feedback
            exit;
        }

        // 4. Tenta criar o feedback usando o Model
        if ($this->feedbackModel->create($descricao, $idCliente)) {
            $_SESSION['success_message'] = 'Seu feedback foi enviado com sucesso! Obrigado.';
        } else {
            $_SESSION['error_message'] = 'Ocorreu um erro ao enviar seu feedback. Tente novamente.';
        }
        
        // 5. Redireciona de volta para a página principal
        header('Location: paginaPrincipalUser.php#feedback');
        exit;
    }

    public function listAll() {
        return $this->feedbackModel->getAll();
    }
}
?>