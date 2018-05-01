#! /usr/bin/env php
<?php

use Otus\Core\ControllerWorkerFactory;
use Otus\Core\Database;
use Otus\Exceptions\RabbitException;
use Otus\Repositories\FilmRepository;

require_once(__DIR__ . '/../bootstrap/autoload.php');


$daemon = array_key_exists('d', getopt("d::"));

$workerFactory = $container->get(ControllerWorkerFactory::class);
$database = $container->get(Database::class);
$fileRepository = $container->get(FilmRepository::class);

try {
    $workerSubscriber = $workerFactory->getSubscriber();
    $workerSubscriber->listen($database, $fileRepository, $daemon);
} catch (RabbitException $e) {
    echo sprintf("Subscriber could not be started. Error text: %s", $e->getMessage());
    exit;
}
