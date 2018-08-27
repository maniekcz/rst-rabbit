<?php

namespace App\Controller\Api;

use App\Entity\Order;
use App\Form\Type\ComplainFormType;
use App\Form\Type\OrderFormType;
use App\Services\Complain\ComplainsManager;
use App\Services\Order\OrdersManager;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class OrderController
 * @package App\Controller
 */
class OrderController extends FOSRestController
{
    /**
     * @var OrdersManager
     */
    protected $ordersManager;

    /**
     * @var ComplainsManager
     */
    private $complainsManager;

    /**
     * OrderController constructor.
     * @param OrdersManager $ordersManager
     * @param ComplainsManager $complainsManager
     */
    public function __construct(
        OrdersManager $ordersManager,
        ComplainsManager $complainsManager
    )
    {
        $this->ordersManager = $ordersManager;
        $this->complainsManager = $complainsManager;
    }

    /**
     * Create Complain
     * @Route(path="/order/{order}/complain", name="create.complain", methods={"POST"})
     * @View(serializerGroups={"Default"})
     *
     * @param Order $order
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     *
     */
    public function createComplain(Order $order, Request $request)
    {
        $form = $this->get('form.factory')->createNamed('', ComplainFormType::class, [], [
            'csrf_protection' => false,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->complainsManager->createComplain($order->getId(), $data['complain']);
            return $this->view([]);
        }
        return $this->view($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * Create Order
     * @Route(path="/order", name="create.order", methods={"POST"})
     * @View(serializerGroups={"Default"})
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     *
     */
    public function createOrder(Request $request)
    {
        $form = $this->get('form.factory')->createNamed('', OrderFormType::class, [], [
            'csrf_protection' => false,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->ordersManager->createOrder($data['notes'], $data['items']);
            return $this->view([]);
        }
        return $this->view($form->getErrors(true, false), Response::HTTP_BAD_REQUEST);
    }

}