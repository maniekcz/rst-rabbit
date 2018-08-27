<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\ORM\EntityRepository;

/**
 * Class OrderRepository.
 */
class OrderRepository extends EntityRepository implements Orders
{
    public function findById(int $id)
    {
        return parent::find($id);
    }

    public function save(Order $order): void
    {
        $this->_em->persist($order);
        $this->_em->flush();
    }
}
