<?php

namespace Otus\Interfaces;

use Otus\Exceptions\RabbitException;

interface WorkerSenderInterface
{
    /**
     * @param string $message
     *
     * @return bool
     *
     * @throws RabbitException
     */
    public function execute(string $message): bool;
}