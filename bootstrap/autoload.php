<?php

use Otus\Controllers\PopularFilmsByAgeRangeController;
use Otus\Controllers\PopularFilmsByGenreController;
use Otus\Controllers\PopularFilmsByPeriodController;
use Otus\Controllers\PopularFilmsByProfessionController;
use Otus\Core\ControllerFactory;
use Otus\Core\Database;
use Otus\Core\FilmBuilder;
use Otus\Core\RequestBuilder;
use Otus\Dto\FilmOptionsDto;
use Otus\Interfaces\ControllerFactoryInterface;
use Otus\Interfaces\RequestBuilderInterface;
use Otus\Repositories\FilmRepository;
use Otus\Services\PopularFilmsByAgeRangeService;
use Otus\Services\PopularFilmsByGenreService;
use Otus\Services\PopularFilmsByPeriodService;
use Otus\Services\PopularFilmsByProfessionService;

$root = dirname(__DIR__);

require "{$root}/vendor/autoload.php";

$builder = new \DI\ContainerBuilder();

$builder->addDefinitions(array(
    'router' => array(
        '/popular/films/by-age-range' => DI\get(PopularFilmsByAgeRangeController::class),
        '/popular/films/by-genres' => DI\get(PopularFilmsByGenreController::class),
        '/popular/films/by-period' => DI\get(PopularFilmsByPeriodController::class),
        '/popular/films/by-professions' => DI\get(PopularFilmsByProfessionController::class),
    ),

    'db.username' => DI\env('db.username', 'postgres'),
    'db.password' => DI\env('db.password', ''),
    'db.host' => DI\env('db.host', 'postgresql'),
    'db.port' => DI\env('db.port', 5432),
    'db.name' => DI\env('db.name', 'movielens'),

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
            DI\get(FilmOptionsDto::class)
        ),

    PopularFilmsByGenreController::class => DI\object()
        ->constructor(
            DI\get(FilmRepository::class),
            DI\get(PopularFilmsByGenreService::class),
            DI\get(FilmOptionsDto::class)
        ),

    PopularFilmsByPeriodController::class => DI\object()
        ->constructor(
            DI\get(FilmRepository::class),
            DI\get(PopularFilmsByPeriodService::class),
            DI\get(FilmOptionsDto::class)
        ),

    PopularFilmsByProfessionController::class => DI\object()
        ->constructor(
            DI\get(FilmRepository::class),
            DI\get(PopularFilmsByProfessionService::class),
            DI\get(FilmOptionsDto::class)
        ),

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