<?php

use Otus\Controllers\AddFilmController;
use Otus\Controllers\PopularFilmsByAgeRangeController;
use Otus\Controllers\PopularFilmsByGenreController;
use Otus\Controllers\PopularFilmsByPeriodController;
use Otus\Controllers\PopularFilmsByProfessionController;
use Otus\Core\ControllerFactory;
use Otus\Core\Database;
use Otus\Core\FilmBuilder;
use Otus\Core\RequestBuilder;
use Otus\Core\ResponseBuilder;
use Otus\Core\WorkerSender;
use Otus\Dto\FilmOptionsDto;
use Otus\Interfaces\AddFilmServiceInterface;
use Otus\Interfaces\ControllerFactoryInterface;
use Otus\Interfaces\RequestBuilderInterface;
use Otus\Interfaces\WorkerSenderInterface;
use Otus\Repositories\FilmRepository;
use Otus\Services\PopularFilmsByAgeRangeService;
use Otus\Services\PopularFilmsByGenreService;
use Otus\Services\PopularFilmsByPeriodService;
use Otus\Services\PopularFilmsByProfessionService;
use Otus\Services\RabbitFilmService;

$root = dirname(__DIR__);

require "{$root}/vendor/autoload.php";

$builder = new \DI\ContainerBuilder();

$builder->addDefinitions(array(
    'router' => array(
        '/popular/films/by-age-range' => DI\get(PopularFilmsByAgeRangeController::class),
        '/popular/films/by-genres' => DI\get(PopularFilmsByGenreController::class),
        '/popular/films/by-period' => DI\get(PopularFilmsByPeriodController::class),
        '/popular/films/by-professions' => DI\get(PopularFilmsByProfessionController::class),
        '/film' => DI\get(AddFilmController::class)
    ),

    'db.username' => DI\env('db.username', 'postgres'),
    'db.password' => DI\env('db.password', 'postgres'),
    'db.host' => DI\env('db.host', 'postgresql'),
    'db.port' => DI\env('db.port', 5432),
    'db.name' => DI\env('db.name', 'movielens'),

    'rb.host' => DI\env('rb.host', 'rabbit'),
    'rb.port' => DI\env('rb.port', 5672),
    'rb.login' => DI\env('rb.login', 'tester'),
    'rb.password' => DI\env('rb.password', 'tester'),

    RequestBuilderInterface::class => DI\object(RequestBuilder::class),

    ControllerFactoryInterface::class => DI\object(ControllerFactory::class),
    ControllerFactory::class => DI\object()
        ->constructor(
            DI\get("router")
        ),

    PopularFilmsByAgeRangeController::class => DI\object()
        ->constructor(
            DI\get(FilmRepository::class),
            DI\get(PopularFilmsByAgeRangeService::class),
            DI\get(FilmOptionsDto::class),
            DI\get(ResponseBuilder::class)
        ),

    PopularFilmsByGenreController::class => DI\object()
        ->constructor(
            DI\get(FilmRepository::class),
            DI\get(PopularFilmsByGenreService::class),
            DI\get(FilmOptionsDto::class),
            DI\get(ResponseBuilder::class)
        ),

    PopularFilmsByPeriodController::class => DI\object()
        ->constructor(
            DI\get(FilmRepository::class),
            DI\get(PopularFilmsByPeriodService::class),
            DI\get(FilmOptionsDto::class),
            DI\get(ResponseBuilder::class)
        ),

    PopularFilmsByProfessionController::class => DI\object()
        ->constructor(
            DI\get(FilmRepository::class),
            DI\get(PopularFilmsByProfessionService::class),
            DI\get(FilmOptionsDto::class),
            DI\get(ResponseBuilder::class)
        ),

    AddFilmController::class => DI\object()
        ->constructor(
            DI\get(WorkerSenderInterface::class),
            DI\get(AddFilmServiceInterface::class),
            DI\get(ResponseBuilder::class)
        ),

    WorkerSenderInterface::class => DI\object(WorkerSender::class),
    WorkerSender::class => DI\object()
        ->constructor(
            DI\get('rb.host'),
            DI\get('rb.port'),
            DI\get('rb.login'),
            DI\get('rb.password')
        ),

    AddFilmServiceInterface::class => DI\object(RabbitFilmService::class),

    PopularFilmsByAgeRangeService::class => DI\object(),
    PopularFilmsByGenreService::class => DI\object(),
    PopularFilmsByPeriodService::class => DI\object(),
    PopularFilmsByProfessionService::class => DI\object(),

    FilmRepository::class => DI\object()
        ->constructor(
            DI\get(\PDO::class),
            DI\get(FilmBuilder::class)
        ),

    FilmBuilder::class => DI\object(),

    Database::class => DI\object()
        ->constructor(
            DI\get('db.host'),
            DI\get('db.port'),
            DI\get('db.username'),
            DI\get('db.password'),
            DI\get('db.name')
        ),

    \PDO::class => DI\factory([Database::class, "getPdo"]),
));

$container = $builder->build();