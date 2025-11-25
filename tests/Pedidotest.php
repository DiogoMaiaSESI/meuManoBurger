<?php
require_once __DIR__ . '/../Model/Pedido.php';
require_once __DIR__ . '/../Controller/PedidoController.php';

use PHPUnit\Framework\TestCase;
use Controller\PedidoController;
use Model\Pedido;

class PedidoTest extends TestCase
{
    private $pedidoController;
    private $mockPedidoModel;

    public function setUp(): void
    {
        $this->mockPedidoModel = $this->createMock(Pedido::class);
        $this->pedidoController = new PedidoController($this->mockPedidoModel);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function criaNovoPedido()
    {
        $this->mockPedidoModel->method('criarPedido')
            ->willReturn(true);

        $resultado = $this->pedidoController->criarPedido(5, 10, "UT4-Z", 2, 150.00, "retirada_loja", "pendente");
        $this->assertTrue($resultado);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function buscaPedidoPorCodigoExistente()
    {
        $this->mockPedidoModel->method('getEqualsCodigos')
            ->with("UT4-Z")
            ->willReturn([['id_pedido' => 20]]);

        $resultado = $this->pedidoController->getPedidoByCodigo("UT4-Z");
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('id_pedido', $resultado[0]);
        $this->assertEquals(20, $resultado[0]['id_pedido']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function getIdPedidoByCodigo()
    {
        $this->mockPedidoModel->method('getPedidoByCodigo')
            ->with("UT4-Z")
            ->willReturn(['id_pedido' => 20]);

        $resultado = $this->pedidoController->getIdPedidoByCodigo("UT4-Z");
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('id_pedido', $resultado);
        $this->assertEquals(20, $resultado['id_pedido']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function adicionaProdutoAPedidoExistente()
    {
        $this->mockPedidoModel->method('criarPedido')
            ->willReturn(true);

        $resultado = $this->pedidoController->criarPedido(8, 10, "UT4-Z", 1, 75.00, "retirada_loja", "pendente");
        $this->assertTrue($resultado);
    }
}