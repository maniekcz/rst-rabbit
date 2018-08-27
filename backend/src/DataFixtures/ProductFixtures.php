<?php
namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    const NAME_PRODUCT = 'product';
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $name = static::NAME_PRODUCT . $i;
            $product = new Product($name, 'code' . $i);
            $manager->persist($product);
            $this->addReference($name, $product);
        }
        $manager->flush();
    }
}
