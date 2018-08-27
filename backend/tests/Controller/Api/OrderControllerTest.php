<?php

namespace App\Tests\Controller\Api;

use App\DataFixtures\OrderFixtures;
use App\DataFixtures\ProductFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    private $em;

    private $order;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $loader = new Loader();

        $loader->addFixture(new ProductFixtures());
        $loader->addFixture(new OrderFixtures());

        $purger = new ORMPurger($this->em);
        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());
        $this->order = $executor->getReferenceRepository()->getReference('order1');
        parent::setUp();
    }

    public function testOrder()
    {
        $client = static::createClient();
        $client->enableProfiler();
        $client->request('POST', '/api/order', ['items' => [['product' => 'code1', 'quantity' => 1]], 'notes' => 'test notes']);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testWrongOrder()
    {
        $client = static::createClient();
        $client->request('POST', '/api/order', ['products' => [100], 'notes' => 'test notes']);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testComplain()
    {
        $orderId = $this->order->getId();
        $client = static::createClient();
        $client->request('POST', '/api/order/' . $orderId . '/complain', ['complain' => 'test complain']);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testWrongComplain()
    {
        $orderId = 'test';
        $client = static::createClient();
        $client->request('POST', '/api/order/' . $orderId . '/complain', ['complain' => 'test complain']);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
