<?php

namespace Otus\Services;

use Otus\Dto\FilmOptionsDto;
use Otus\Exceptions\FilmsException;
use Otus\Interfaces\FilmRepositoryInterface;
use Otus\Interfaces\FilmServiceInterface;

class PopularFilmsByProfessionService implements FilmServiceInterface
{
    /**
     * @var FilmRepositoryInterface
     */
    private $filmRepository;

    public function __construct(FilmRepositoryInterface $filmRepository)
    {
        $this->filmRepository = $filmRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilms(FilmOptionsDto $optionsDto): array
    {
        $professionsList = $optionsDto->getProfessionsList();

        if (!isset($professionsList))
            throw new FilmsException(sprintf("Item by id professionsList not found"));

        return $this->filmRepository->getPopularFilmsByProfession($professionsList);
    }
}