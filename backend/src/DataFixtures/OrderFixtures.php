<?php
namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $order = new Order();
        $order->setNotes('some notes test');
//        $product = $this->getReference(ProductFixtures::NAME_PRODUCT.'1');
//        if ($product instanceof Product) {
//            $order->addItem(
//                new OrderItem($product, '100', $order)
//            );
//        }
        $manager->persist($order);
        $manager->flush();
        $this->addReference('order1', $order);
    }

    public function getDependencies()
    {
        return array(
            ProductFixtures::class,
        );
    }
}