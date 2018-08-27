<?php

namespace App\Repository;

use App\Entity\Complain;
use Doctrine\ORM\EntityRepository;

/**
 * Class OrderRepository.
 */
class ComplainRepository extends EntityRepository implements Complains
{
    public function findById(int $id)
    {
        return parent::find($id);
    }

    public function save(Complain $complain): void
    {
        $this->_em->persist($complain);
        $this->_em->flush();
    }
}
