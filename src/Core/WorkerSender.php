<?php

namespace Otus\Core;

use Otus\Exceptions\RabbitException;
use Otus\Interfaces\WorkerSenderInterface;

class WorkerSender implements WorkerSenderInterface
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

    const ROUTING_KEY = 'add.film';
    const EXCHANGE_NAME = 'add_film';
    const QUEUE_NAME = 'add_film_queue';

    public function __construct(string $host, int $port, string $login, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(string $message): bool
    {
        try {
            $exchange = $this->getExchange();
            $queue = $this->getQueue();
            $queue->bind(self::EXCHANGE_NAME, self::ROUTING_KEY);

            return $exchange->publish(
                $message,
                self::ROUTING_KEY,
                AMQP_NOPARAM
            );
        } catch (\AMQPChannelException $e) {
            throw new RabbitException("Can't create rabbit chanel");
        } catch (\AMQPConnectionException $e) {
            throw new RabbitException("Can't connect to rabbit");
        } catch (\AMQPExchangeException $e) {
            throw new RabbitException("Can't create rabbit exchange");
        } catch (\AMQPQueueException $e) {
            throw new RabbitException("Can't create rabbit queue");
        }
    }

    /**
     * @return \AMQPChannel
     *
     * @throws \AMQPConnectionException
     */
    protected function getChanel(): \AMQPChannel
    {
        $connect = new \AMQPConnection([
            'host' => $this->host,
            'vhost' => '/',
            'port' => $this->port,
            'login' => $this->login,
            'password' => $this->password
        ]);
        $connect->connect();

        return new \AMQPChannel($connect);
    }

    /**
     * @return \AMQPExchange
     *
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     */
    protected function getExchange(): \AMQPExchange
    {
        $exchange = new \AMQPExchange($this->getChanel());
        $exchange->setName(self::EXCHANGE_NAME);
        $exchange->setType(AMQP_EX_TYPE_DIRECT);
        $exchange->setFlags(AMQP_DURABLE);
        $exchange->declareExchange();

        return $exchange;
    }

    /**
     * @return \AMQPQueue
     *
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPQueueException
     */
    protected function getQueue(): \AMQPQueue
    {
        $queue = new \AMQPQueue($this->getChanel());
        $queue->setName(self::QUEUE_NAME);
        $queue->setFlags(AMQP_DURABLE);
        $queue->declareQueue();

        return $queue;
    }
}