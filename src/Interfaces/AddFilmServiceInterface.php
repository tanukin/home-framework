<?php

namespace Otus\Interfaces;

use Otus\Entities\Film;
use Otus\Exceptions\RabbitException;

interface AddFilmServiceInterface
{
    /**
     * @param WorkerSenderInterface $sender
     * @param Film $film
     *
     * @return array
     *
     * @throws RabbitException
     */
    public function add(WorkerSenderInterface $sender, Film $film): array;
}