<?php
require_once __DIR__ . '/../Model/Adm.php';
require_once __DIR__ . '/../Controller/AdmController.php';


use PHPUnit\Framework\TestCase;
use Controller\AdmController;
use Model\Adm;


class AdmTest extends TestCase
{
    private $admController;
    private $mockAdmModel;
   
    public function setUp(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
       


        $this->mockAdmModel = $this->createMock(Adm::class);
       


        $this->admController = new AdmController($this->mockAdmModel);
    }


    protected function tearDown(): void
    {
        $_SESSION = [];
    }


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_create_adm()
    {
         $this->mockAdmModel->method('getAdmByEmail')->willReturn(false);
        $this->mockAdmModel->method('registerAdm')->willReturn(true);
       
        $admResult = $this->admController->createAdm("Mariane Silva", "mariane.mmb.admin@gmail.com", "1234", '');
        $this->assertTrue($admResult);
    }


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_sign_in()
    {


        $this->mockAdmModel->method('getAdmByEmail')->willReturn([
            "id_adm" => 1,
            "nome_adm" => "Mariane Silva",
            "email_adm" => "mariane.mmb.admin@gmail.com",
            "senha_adm" => password_hash("1234", PASSWORD_DEFAULT),
        ]);


        $admResult = $this->admController->login("mariane.mmb.admin@gmail.com", "1234");
       
        $this->assertTrue($admResult);
        $this->assertEquals(1, $_SESSION["id_adm"]);
        $this->assertEquals('Mariane Silva', $_SESSION["nome_adm"]);
        $this->assertEquals('mariane.mmb.admin@gmail.com', $_SESSION["email_adm"]);
    }


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_login_with_invalid_credentials()
    {
        $this->mockAdmModel->method('getAdmByEmail')->willReturn([
            "id_adm" => 1,
            "nome_adm" => "Mariane Silva",
            "email_adm" => "mariane.mmb.admin@gmail.com",
            "senha_adm" => password_hash("1234", PASSWORD_DEFAULT),
        ]);


        $admResult = $this->admController->login("mariane.mmb.admin@gmail.com", "senha_errada");
       
        $this->assertFalse($admResult);
    }
}
