<?php

namespace App\Services\Complain;

use App\Entity\Complain;
use App\Entity\Order;

interface ComplainsManager
{
    public function createComplain(int $order, string $complainMessage): Complain;
}