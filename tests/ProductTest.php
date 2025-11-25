<?php

use Controller\ProductController;
use PHPUnit\Framework\TestCase;
use Model\Product;

class ProductTest extends TestCase {
    protected $backupGlobals = true;
    private $productController;
    private $mockProductModel;
    protected function setUp (): void {
        $this->mockProductModel = $this->createStub(Product::class);
        $this->productController = new ProductController($this->mockProductModel);
    }


    #[PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_create_product_with_valid_credentials () {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $expectedProduct = ['success' => true];

        $this->mockProductModel
            ->method('createProduct')
            ->willReturn($expectedProduct);

        $resultado = $this->productController->create(
            'Pastel de Forno de Frango',
            '12.30',
            'Lanche',
            'Pastel de forno com frango, o melhor da cidade!',
            file_get_contents(__DIR__ . '/../templates/assets/img/xbacon.png'),
            1
        );
        $this->assertTrue($resultado['success']);
    }
}

?>