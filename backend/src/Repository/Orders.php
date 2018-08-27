<?php

namespace App\Repository;

use App\Entity\Order;

interface Orders
{
    public function findById(int $id);
    public function save(Order $order): void;
}
