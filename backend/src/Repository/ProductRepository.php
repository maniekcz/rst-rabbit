<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ProductRepository.
 */
class ProductRepository extends EntityRepository implements Products
{
    public function findById(int $id)
    {
        return parent::find($id);
    }

    public function findByCode(string $code)
    {
        return parent::findOneBy(['code' => $code]);
    }
}
