<?php

namespace App\Services;

use App\Entity\Complain;
use App\Entity\Order;
use App\Mailer\RstMailer;
use App\Services\Message\MessageFactoryInterface;

class EmailProvider
{
    /**
     * @var MessageFactoryInterface
     */
    private $messageFactory;
    /** @var array */
    private $parameters = [];
    private $mailer;
    private $emailFromName;
    private $emailFromAddress;
    private $notificationEmail;
    /**
     * EmailProvider constructor.
     *
     * @param MessageFactoryInterface $messageFactory
     * @param RstMailer              $mailer
     * @param array                   $parameters
     */
    public function __construct(MessageFactoryInterface $messageFactory, RstMailer $mailer, array $parameters)
    {
        $this->messageFactory = $messageFactory;
        $this->mailer = $mailer;
        $this->parameters = $parameters;
        $this->emailFromName = isset($parameters['from_name']) ? $parameters['from_name'] : '';
        $this->emailFromAddress = isset($parameters['from_address']) ? $parameters['from_address'] : '';
        $this->notificationEmail = isset($parameters['notification_email']) ? $parameters['notification_email'] : '';
    }
    /**
     * @param string      $subject
     * @param string      $email
     * @param string|null $template
     * @param array|null  $params
     *
     * @return bool
     */
    public function sendMessage(string $subject, string $email, string $template = null, array $params = null)
    {
        $message = $this->messageFactory->create();
        $message->setSubject($subject);
        $message->setContent('');
        $message->setRecipientEmail($email);
        $message->setRecipientName($email);
        $message->setSenderEmail($this->emailFromAddress);
        $message->setSenderName($this->emailFromName);
        $message->setTemplate($template);
        $message->setParams($params);
        return $this->mailer->send($message);
    }

    /**
     * @param Order $order
     * @return bool
     */
    public function orderNotification(Order $order)
    {
        return $this->sendMessage(
            'Order was placed',
            $this->notificationEmail,
            'order.html.twig',
            [
                'order' => $order,
            ]
        );
    }

    /**
     * @param Complain $complain
     * @return bool
     */
    public function complainNotification(Complain $complain)
    {
        return $this->sendMessage(
            'Complain was placed',
            $this->notificationEmail,
            'complain.html.twig',
            [
                'complain' => $complain,
            ]
        );
    }
}
