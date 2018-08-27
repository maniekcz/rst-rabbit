<?php

namespace App\Services\Order;

use App\Entity\Order;

interface OrdersManager
{
    public function createOrder(string $notes, array $items): Order;
}
