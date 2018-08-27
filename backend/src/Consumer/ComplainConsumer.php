<?php
namespace App\Consumer;

use App\Entity\Complain;
use App\Repository\Complains;
use App\Services\EmailProvider;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class ComplainConsumer implements ConsumerInterface
{
    /**
     * @var Complains
     */
    private $complains;

    /**
     * @var EmailProvider
     */
    private $mailer;

    /**
     * OrderConsumer constructor.
     * @param Complains $complains
     * @param EmailProvider $mailer
     */
    public function __construct(
        Complains $complains,
        EmailProvider $mailer
    ) {
        $this->complains = $complains;
        $this->mailer  = $mailer;
    }

    public function execute(AMQPMessage $msg)
    {
        $complainId = unserialize($msg->getBody());
        $complain = $this->complains->findById($complainId);
        if ($complain instanceof Complain) {
            $this->mailer->complainNotification($complain);
        } else {
            return false;
        }
    }
}
