<?php

namespace App\Test\Services\Order;

use App\Entity\Order;

use App\Entity\Product;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Services\Order\OrderManager;
use PHPUnit\Framework\TestCase;

class OrderManagerTest extends TestCase
{
    private $orders;

    private $products;

    public function setUp()
    {
        $this->orders = $this->getMockBuilder(OrderRepository::class)->disableOriginalConstructor()->setMethods(['save'])->getMock();
        $this->products = $this->createMock(ProductRepository::class);
    }

    /**
     * @test
     */
    public function testCreateOrder()
    {
        $product = new Product('test product', 'code1');
        $this->products->expects($this->any())->method('findByCode')->willReturn($product);
        $orderManager = new OrderManager($this->orders, $this->products);
        $order = $orderManager->createOrder(
            'test notes',
            [[
                'product' => 'code1',
                'quantity' => 100
            ]]
        );
        $this->assertInstanceOf(Order::class, $order);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateWrongOrder()
    {
        $this->products->expects($this->any())->method('findByCode')->willReturn(null);
        $orderManager = new OrderManager($this->orders, $this->products);
        $order = $orderManager->createOrder(
        'test notes',
            [[
                'product' => 1,
                'quantity' => 100
            ]]
        );
    }
}
