<?php

namespace App\Test\Services\Order;

use App\Entity\Complain;
use App\Services\Complain\ComplainManager;
use App\Services\Complain\ComplainProducer;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use PHPUnit\Framework\TestCase;

class ComplainProducerTest extends TestCase
{
    private $complains;

    private $producer;

    public function setUp()
    {
        $complain = new Complain();
        $complainManager = $this->createMock(ComplainManager::class);
        $complainManager->expects($this->any())->method('createComplain')->willReturn($complain);
        $this->complains = $complainManager;
        $this->producer = $this->getMockBuilder(Producer::class)->disableOriginalConstructor()->setMethods(['publish'])->getMock();
    }

    /**
     * @test
     */
    public function testCreateOrder()
    {
        $orderManager = new ComplainProducer($this->complains, $this->producer);
        $order = $orderManager->createComplain(
            1,
            'test complain message'
        );
        $this->assertInstanceOf(Complain::class, $order);
    }
}
