<?php

namespace Otus\Controllers;

use Otus\Core\ResponseBuilder;
use Otus\Dto\Error;
use Otus\Dto\FilmOptionsDto;
use Otus\Exceptions\FilmsException;
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
     * @var ResponseBuilder
     */
    private $responseBuilder;

    /**
     * PopularFilmsByGenreController constructor.
     *
     * @param FilmRepositoryInterface $filmRepository
     * @param FilmServiceInterface $filmService
     * @param FilmOptionsDto $optionsDto
     * @param ResponseBuilder $responseBuilder
     */
    public function __construct(
        FilmRepositoryInterface $filmRepository,
        FilmServiceInterface $filmService,
        FilmOptionsDto $optionsDto,
        ResponseBuilder $responseBuilder
    )
    {
        $this->filmRepository = $filmRepository;
        $this->filmService = $filmService;
        $this->optionsDto = $optionsDto;
        $this->responseBuilder = $responseBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(RequestInterface $request): ResponseInterface
    {
        try {
            $this->optionsDto->setFromYear($request->getParam("fromYear", -1));
            $this->optionsDto->setToYear($request->getParam("toYear", -1));

            $data = $this->filmService->getFilms($this->filmRepository, $this->optionsDto);
        } catch (FilmsException $e) {
            $data[] = $this->responseBuilder->createError(Error::BAD_REQUEST, $e->getMessage());
            return $this->responseBuilder->getResponse($data);
        }

        return $this->responseBuilder->getResponse($data);
    }
}