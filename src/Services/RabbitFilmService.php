<?php

namespace Otus\Services;

use Otus\Entities\Film;
use Otus\Exceptions\RabbitException;
use Otus\Interfaces\AddFilmServiceInterface;
use Otus\Interfaces\WorkerSenderInterface;

class RabbitFilmService implements AddFilmServiceInterface
{

    const ANSWER = ['success' => true, 'message' => 'OK'];

    /**
     * {@inheritdoc}
     */
    public function add(WorkerSenderInterface $sender, Film $film): array
    {
        $jsonData = json_encode($film);

        if (!$sender->execute($jsonData))
            throw new RabbitException('Failed to add to queue');

        return self::ANSWER;
    }
}