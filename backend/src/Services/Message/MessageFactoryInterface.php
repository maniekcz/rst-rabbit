<?php

namespace App\Services\Message;

use App\Model\MessageInterface;

interface MessageFactoryInterface
{
    /**
     * Create message object.
     *
     * @return MessageInterface
     */
    public function create();
}
