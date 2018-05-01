<?php

namespace Otus\Core;

use Otus\Interfaces\WorkerSenderInterface;
use Otus\Interfaces\WorkerSubscriberInterface;

class ControllerWorkerFactory
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * ControllerWorker constructor.
     *
     * @param string $host
     * @param int $port
     * @param string $login
     * @param string $password
     */
    public function __construct(string $host, int $port, string $login, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->login = $login;
        $this->password = $password;
    }

    public function getSender(): WorkerSenderInterface
    {
        return new WorkerSender($this->host, $this->port, $this->login, $this->password);
    }

    public function getSubscriber(): WorkerSubscriberInterface
    {
        return new WorkerSubscriber($this->host, $this->port, $this->login, $this->password);
    }
}