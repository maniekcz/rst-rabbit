<?php

namespace App\Services\Complain;

use App\Entity\Complain;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

/**
 * Class ComplainProducer.
 */
class ComplainProducer implements ComplainsManager
{
    /**
     * @var ComplainsManager
     */
    private $complainsManager;

    /**
     * @var ProducerInterface
     */
    private $producer;

    /**
     * ComplainProducer constructor.
     * @param ComplainsManager $complainsManager
     * @param ProducerInterface $producer
     */
    public function __construct(
        ComplainsManager $complainsManager,
        ProducerInterface $producer
    ) {
        $this->complainsManager = $complainsManager;
        $this->producer = $producer;
    }

    public function createComplain(int $order, string $complainMessage): Complain
    {
        $complain = $this->complainsManager->createComplain($order, $complainMessage);
        $this->producer->publish(serialize($complain->getId()));
        return $complain;
    }
}
