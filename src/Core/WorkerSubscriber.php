<?php

namespace Otus\Core;

use Otus\Exceptions\RabbitException;
use Otus\Interfaces\FilmRepositoryInterface;
use Otus\Interfaces\WorkerSubscriberInterface;
use Otus\Repositories\FilmRepository;

class WorkerSubscriber implements WorkerSubscriberInterface
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
    const PID_FILE = "/tmp/subscriber_daemon_pid.tmp";

    public function __construct(string $host, int $port, string $login, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * @param Database $database
     * @param FilmRepository $filmRepository
     * @param bool $daemon
     *
     * @return void
     *
     * @throws RabbitException
     */
    public function listen(Database $database, FilmRepository $filmRepository, bool $daemon): void
    {
        if ($daemon)
            $this->daemonOn($database);
        else
            $this->loop($filmRepository);
    }

    /**
     * @param Database $database
     *
     * @throws RabbitException
     */
    private function daemonOn(Database $database)
    {
        if ($this->isDaemonRun(self::PID_FILE)) {
            echo("Daemon already run");
            exit;
        }

        $pid = pcntl_fork();

        if ($pid) {
            exit;
        }

        fclose(STDIN);
        fclose(STDOUT);
        fclose(STDERR);

        posix_setsid();

        cli_set_process_title("subscriber worker process");
        file_put_contents(self::PID_FILE, posix_getpid());

        //Создаю новое подключение с БД.
        $filmRepository = new FilmRepository($database->getPdo(), new FilmBuilder());

        $this->loop($filmRepository);
        exit(0);
    }

    /**
     * @param FilmRepositoryInterface $filmRepository
     *
     * @throws RabbitException
     */
    private function loop(FilmRepositoryInterface $filmRepository)
    {
        try {
            $exchange = $this->getExchange();
            $queue = $this->getQueue();
            $queue->bind(self::EXCHANGE_NAME, self::ROUTING_KEY);

            $queue->consume(function (
                \AMQPEnvelope $envelope,
                \AMQPQueue $queue
            ) use ($filmRepository) {
                if ($this->sendToDB($filmRepository, $envelope->getBody())) {
                    $queue->ack($envelope->getDeliveryTag());
                } else {
                    $queue->nack($envelope->getDeliveryTag(), AMQP_REQUEUE);
                }
            });

        } catch (\AMQPChannelException $e) {
            throw new RabbitException("Can't create rabbit chanel");
        } catch (\AMQPConnectionException $e) {
            throw new RabbitException("Can't connect to rabbit");
        } catch (\AMQPExchangeException $e) {
            throw new RabbitException("Can't create rabbit exchange");
        } catch (\AMQPQueueException $e) {
            throw new RabbitException("Can't create rabbit queue");
        } catch (\AMQPEnvelopeException $e) {
            throw new RabbitException("Can't create rabbit envelope");
        }
    }

    private function isDaemonRun($pid_file): bool
    {
        if (!is_file($pid_file))
            return false;

        $pid = file_get_contents($pid_file);

        if (posix_kill($pid, 0))
            return true;

        if (!unlink($pid_file)) {
            echo "Can't delete file $pid_file";
            exit(-1);
        }

        return false;
    }

    /**
     * @param FilmRepositoryInterface $filmRepository
     * @param string $message
     *
     * @return bool
     */
    private function sendToDB(FilmRepositoryInterface $filmRepository, string $message): bool
    {
        $data = json_decode($message, true);

        return $filmRepository->addFilm($data['title'], $data['release-date']);
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