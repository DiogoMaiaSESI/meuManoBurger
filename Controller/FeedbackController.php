<?php
namespace Controller;

require_once __DIR__ . '/../Model/Feedback.php';
use Model\Feedback;

class FeedbackController {
    private $feedbackModel;

    public function __construct(Feedback $feedbackModel) {
        $this->feedbackModel = $feedbackModel;
    }

    public function create() {
        // Só permite a criação se o usuário estiver logado e o método for POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['id_cliente'])) {
            $_SESSION['error_message'] = 'Acesso negado.';
            header('Location: paginaPrincipalUser.php');
            exit;
        }

        $descricao = filter_input(INPUT_POST, 'descricao_feedback', FILTER_SANITIZE_SPECIAL_CHARS);
        $idCliente = $_SESSION['id_cliente'];

        if (empty($descricao)) {
            $_SESSION['error_message'] = 'O campo de feedback não pode estar vazio.';
            header('Location: paginaPrincipalUser.php#feedback');
            exit;
        }

        if ($this->feedbackModel->create($descricao, $idCliente)) {
            $_SESSION['success_message'] = 'Seu feedback foi enviado com sucesso! Obrigado.';
        } else {
            $_SESSION['error_message'] = 'Ocorreu um erro ao enviar seu feedback. Tente novamente.';
        }
        
        header('Location: paginaPrincipalUser.php#feedback');
        exit;
    }

    public function listAll() {
        return $this->feedbackModel->getAll();
    }
}
?>