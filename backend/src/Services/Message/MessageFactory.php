<?php

namespace App\Services\Message;

use App\Model\Message;

class MessageFactory implements MessageFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new Message();

    }
}