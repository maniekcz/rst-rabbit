<?php

namespace App\Repository;

use App\Entity\Complain;

interface Complains
{
    public function findById(int $id);
    public function save(Complain $order): void;
}
