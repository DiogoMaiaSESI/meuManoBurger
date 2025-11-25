
<?php

use Controller\ClienteController;
use PHPUnit\Framework\TestCase;
use Model\Cliente;

class ClienteTest extends TestCase {
    private $clienteController;
    private $mockClienteModel;
    protected function setUp (): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->mockClienteModel = $this->createMock(Cliente::class);
        $this->clienteController = new ClienteController($this->mockClienteModel);
    }

    #[PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_create_client_with_valid_credentials () {
        $expectedCliente = [
            'nome_cliente' => 'Beatriz Mota',
            'email_cliente' => 'chata@example.com',
            'senha_cliente' => password_hash('12345', PASSWORD_DEFAULT)
        ];
        $this->mockClienteModel->method('registerClienteUser')->willReturn($expectedCliente);
        $createCliente = $this->clienteController->createCliente('Beatriz Mota', 'chata@example.com', '12345', file_get_contents(__DIR__ . '/../templates/assets/img/google.png'));
        $this->assertEquals('Beatriz Mota', $createCliente['nome_cliente']);
        $this->assertEquals('chata@example.com', $createCliente['email_cliente']);
        $this->assertFileExists(__DIR__ . '/../templates/assets/img/google.png');
        $this->assertTrue(password_verify('12345', $createCliente['senha_cliente']));
        
    }
        
    #[PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_create_client_with_email_already_used () {
        $this->mockClienteModel->method('getClienteByEmail')->willReturn([
            'id_cliente' => 1,
            'nome_cliente' => 'Chata Santos',
            'email_cliente' => 'chata@example.com',
            'senha_cliente' => password_hash('12345',PASSWORD_DEFAULT),
            'imagem_cliente' => file_get_contents(__DIR__ . '/../templates/assets/img/google.png')
        ]);
        $this->mockClienteModel->method('registerClienteUser')->willThrowException(new \Exception('Email já cadastrado.'));
        $this->expectExceptionMessage('Email já cadastrado.');
        $this->clienteController->createCliente('Chata Santos', 'chata@example.com', '12345', file_get_contents(__DIR__ . '/../templates/assets/img/google.png'));
    }

   
    #[PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_sign_in_with_valid_credentials () {
        $this->clienteController->createCliente('Beatriz Mota', 'chata@example.com', '12345', file_get_contents(__DIR__ . '/../templates/assets/img/google.png'));
        $this->mockClienteModel->method('getClienteByEmail')->willReturn([
            'id_cliente' => 1,
            'nome_cliente' => 'Beatriz Mota',
            'email_cliente' => 'chata@example.com',
            'senha_cliente'=> '$2y$10$Ea9bPWOGDBwmtAVCl4jZAuW0s6xXFqkXkUwcFxv2qFQTnQIQDOYzS',
            'imagem_cliente' => file_get_contents(__DIR__ . '/../templates/assets/img/google.png')
        ]);
        $this->assertTrue($this->clienteController->login('chata@example.com', '12345'));
    }

    #[PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_login_with_invalid_credentials () {
        $this->mockClienteModel->method('getClienteByEmail')->willReturn(false);
        $this->assertFalse($this->clienteController->login('chata@example.com', '123457'));
    }
}

?>
