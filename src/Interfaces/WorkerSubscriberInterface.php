<?php

namespace Otus\Interfaces;

use Otus\Core\Database;
use Otus\Exceptions\RabbitException;
use Otus\Repositories\FilmRepository;

interface WorkerSubscriberInterface
{
    /**
     * @param Database $database
     * @param FilmRepository $filmRepository
     * @param bool $daemon
     *
     * @return void
     *
     * @throws RabbitException
     */
    public function listen(Database $database, FilmRepository $filmRepository, bool $daemon): void;
}