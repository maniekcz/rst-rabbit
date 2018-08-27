<?php

namespace App\Mailer;

use App\Model\MessageInterface;

interface RstMailer
{
    /**
     * @param MessageInterface $message
     *
     * @return bool
     */
    public function send(MessageInterface $message);
}
