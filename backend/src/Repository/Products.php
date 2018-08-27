<?php

namespace App\Repository;

interface Products
{
    public function findById(int $id);
    public function findByCode(string $code);
}
