<?php
require_once __DIR__ . '/../Model/Estoque.php';
require_once __DIR__ . '/../Controller/EstoqueController.php';

use PHPUnit\Framework\TestCase;
use Controller\EstoqueController;
use Model\Estoque;

class EstoqueTest extends TestCase
{
    private $estoqueController;
    private $mockEstoqueModel;

    public function setUp(): void
    {
        $this->mockEstoqueModel = $this->createMock(Estoque::class);
        $this->estoqueController = new EstoqueController($this->mockEstoqueModel);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function insertProdutoNoEstoque()
    {
        $this->mockEstoqueModel->method('insertestoque')
            ->with(50, 5)
            ->willReturn(true);

        $resultado = $this->estoqueController->insEstoque(50, 5);
        $this->assertTrue($resultado);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function subtracaoComEstoqueSuficiente()
    {
        $this->mockEstoqueModel->method('subtracaoEstoque')
            ->with(10)
            ->willReturn("Pedido processado. Estoque atualizado de 50 para 40.");

        $resultado = $this->estoqueController->subEstoque(10);
        $this->assertEquals("Pedido processado. Estoque atualizado de 50 para 40.", $resultado);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function subtracaoComEstoqueInsuficiente()
    {
        $this->mockEstoqueModel->method('subtracaoEstoque')
            ->with(11)
            ->willReturn("Estoque insuficiente: disponível 5, pedido 10.");

        $resultado = $this->estoqueController->subEstoque(11);
        $this->assertEquals("Estoque insuficiente: disponível 5, pedido 10.", $resultado);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function atualizarQuantidadeEstoque()
    {
        $this->mockEstoqueModel->method('atualizarEstoque')
            ->with(5, 100) 
            ->willReturn(true);

        $resultado = $this->estoqueController->atEstoque(5, 100);
        $this->assertTrue($resultado);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function obterEstoqueProduto()
    {
        $estoqueEsperado = [
            'id_estoque' => 1,
            'qtd_produto' => 50,
            'id_produto_fk' => 5
        ];

        $this->mockEstoqueModel->method('getEstoque')
            ->with(5)
            ->willReturn($estoqueEsperado);

        $resultado = $this->estoqueController->obtEstoque(5);
        $this->assertEquals($estoqueEsperado, $resultado);
    }
}