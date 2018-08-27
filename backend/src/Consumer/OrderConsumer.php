<?php
namespace App\Consumer;

use App\Entity\Order;
use App\Repository\Orders;
use App\Services\EmailProvider;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class OrderConsumer implements ConsumerInterface
{
    /**
     * @var Orders
     */
    private $orders;

    /**
     * @var EmailProvider
     */
    private $mailer;

    /**
     * OrderConsumer constructor.
     * @param Orders $orders
     * @param EmailProvider $mailer
     */
    public function __construct(
        Orders $orders,
        EmailProvider $mailer
    ) {
        $this->orders = $orders;
        $this->mailer  = $mailer;
    }

    public function execute(AMQPMessage $msg)
    {
        $orderId = unserialize($msg->getBody());
        $order = $this->orders->findById($orderId);
        if ($order instanceof Order) {
            $this->mailer->orderNotification($order);
        } else {
            return false;
        }
    }
}
