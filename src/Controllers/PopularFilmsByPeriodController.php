<?php

namespace Otus\Controllers;

use Otus\Core\HtmlResponse;
use Otus\Dto\FilmOptionsDto;
use Otus\Interfaces\ControllerInterface;
use Otus\Interfaces\FilmRepositoryInterface;
use Otus\Interfaces\FilmServiceInterface;
use Otus\Interfaces\RequestInterface;
use Otus\Interfaces\ResponseInterface;

class PopularFilmsByPeriodController implements ControllerInterface
{
    /**
     * @var FilmRepositoryInterface
     */
    private $filmRepository;
    /**
     * @var FilmServiceInterface
     */
    private $filmService;
    /**
     * @var FilmOptionsDto
     */
    private $optionsDto;

    /**
     * PopularFilmsByGenreController constructor.
     *
     * @param FilmRepositoryInterface $filmRepository
     * @param FilmServiceInterface $filmService
     * @param FilmOptionsDto $optionsDto
     */
    public function __construct(
        FilmRepositoryInterface $filmRepository,
        FilmServiceInterface $filmService,
        FilmOptionsDto $optionsDto
    )
    {
        $this->filmRepository = $filmRepository;
        $this->filmService = $filmService;
        $this->optionsDto = $optionsDto;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(RequestInterface $request): ResponseInterface
    {
        $this->optionsDto->setFromYear($request->getParam("fromYear"));
        $this->optionsDto->setToYear($request->getParam("toYear"));
        $data = $this->filmService->getFilms($this->filmRepository, $this->optionsDto);

        return new HtmlResponse($data);
    }
}