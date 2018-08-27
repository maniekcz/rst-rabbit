<?php

namespace App\Test\Services\Order;

use App\Entity\Order;
use App\Services\Order\OrderManager;
use App\Services\Order\OrderProducer;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use PHPUnit\Framework\TestCase;

class OrderProducerTest extends TestCase
{

    private $orders;

    private $producer;

    public function setUp()
    {
        $order = new Order();
        $orderManager = $this->createMock(OrderManager::class);
        $orderManager->expects($this->any())->method('createOrder')->willReturn($order);
        $this->orders = $orderManager;
        $this->producer = $this->getMockBuilder(Producer::class)->disableOriginalConstructor()->setMethods(['publish'])->getMock();
    }

    /**
     * @test
     */
    public function testCreateOrder()
    {
        $orderManager = new OrderProducer($this->orders, $this->producer);
        $order = $orderManager->createOrder(
        'test notes',
            [[
                'product' => '1',
                'quantity' => 100
            ]]
        );
        $this->assertInstanceOf(Order::class, $order);
    }
}
