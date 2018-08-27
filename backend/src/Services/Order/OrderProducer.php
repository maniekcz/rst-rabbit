<?php

namespace App\Services\Order;

use App\Entity\Order;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

/**
 * Class ComplainProducer.
 */
class OrderProducer implements OrdersManager
{
    /**
     * @var OrdersManager
     */
    private $ordersManager;

    /**
     * @var ProducerInterface
     */
    private $producer;

    /**
     * ComplainProducer constructor.
     * @param OrdersManager $ordersManager
     * @param ProducerInterface $producer
     */
    public function __construct(
        OrdersManager $ordersManager,
        ProducerInterface $producer
    ) {
        $this->ordersManager = $ordersManager;
        $this->producer = $producer;
    }

    public function createOrder(string $notes, array $items): Order
    {
        $order = $this->ordersManager->createOrder($notes, $items);
        $this->producer->publish(serialize($order->getId()));
        return $order;
    }
}
