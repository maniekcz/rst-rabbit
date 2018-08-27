<?php

namespace App\Test\Services\Order;

use App\Entity\Complain;
use App\Entity\Order;
use App\Repository\ComplainRepository;
use App\Repository\OrderRepository;
use App\Services\Complain\ComplainManager;
use PHPUnit\Framework\TestCase;
use \Exception;

class ComplainManagerTest extends TestCase
{
    private $complains;

    private $orders;

    public function setUp()
    {
        $this->complains = $this->getMockBuilder(ComplainRepository::class)->disableOriginalConstructor()->setMethods(['save'])->getMock();
        $this->orders = $this->createMock(OrderRepository::class);
    }

    /**
     * @test
     */
    public function testCreateOrder()
    {
        $order = new Order();
        $this->orders->expects($this->any())->method('findById')->willReturn($order);
        $complainManager = new ComplainManager($this->complains, $this->orders);
        $complain = $complainManager->createComplain(1, 'test complain message');
        $this->assertInstanceOf(Complain::class, $complain);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateWrongOrder()
    {
        $this->orders->expects($this->any())->method('findById')->willReturn(null);
        $complainManager = new ComplainManager($this->complains, $this->orders);
        $complain = $complainManager->createComplain(1, 'test complain message');
    }
}
