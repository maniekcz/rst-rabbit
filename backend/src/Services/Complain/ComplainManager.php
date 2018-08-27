<?php

namespace App\Services\Complain;

use App\Entity\Complain;
use App\Entity\Order;
use App\Repository\Complains;
use App\Repository\Orders;
use JMS\Serializer\Exception\LogicException;

/**
 * Class ComplainManager.
 */
class ComplainManager implements ComplainsManager
{

    /**
     * @var Complains
     */
    private $complains;

    /**
     * @var Orders
     */
    private $orders;

    /**
     * ComplainManager constructor.
     * @param Complains $complains
     * @param Orders $orders
     */
    public function __construct(
        Complains $complains,
        Orders $orders
    ) {
        $this->complains = $complains;
        $this->orders = $orders;
    }

    public function createComplain(int $orderId, string $complainMessage): Complain
    {
        $order = $this->orders->findById($orderId);
        if(!$order instanceof Order) {
            throw new LogicException("Order doesn't exist");
        }
        $complain = new Complain();
        $complain->setOrder($order);
        $complain->setComplain($complainMessage);
        $this->complains->save($complain);
        return $complain;
    }

}