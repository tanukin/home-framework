<?php

namespace Otus\Interfaces;

interface WorkerSenderInterface
{
    /**
     * @param string $jsonData
     *
     * @return bool
     *
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     * @throws \AMQPQueueException
     */
    public function execute(string $jsonData): bool;
}