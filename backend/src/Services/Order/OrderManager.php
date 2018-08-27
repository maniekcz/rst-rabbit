<?php

namespace App\Services\Order;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Repository\Orders;
use App\Repository\Products;

/**
 * Class ComplainManager.
 */
class OrderManager implements OrdersManager
{
    /**
     * @var Orders
     */
    private $orders;

    /**
     * @var Products
     */
    private $products;

    /**
     * ComplainManager constructor.
     * @param Orders $orders
     * @param Products $products
     */
    public function __construct(
        Orders $orders,
        Products $products
    ) {
        $this->orders = $orders;
        $this->products = $products;
    }

    public function createOrder(string $notes, array $items): Order
    {
        $order = new Order();
        $order->setNotes($notes);
        foreach ($items as $item) {
            $product = $this->products->findByCode($item['product']);
            if(!$product instanceof Product) {
                throw new \LogicException("Product doesn't exits");
            }
            $order->addItem(
                new OrderItem($product, $item['quantity'], $order)
            );
        }
        $this->orders->save($order);
        return $order;
    }

}