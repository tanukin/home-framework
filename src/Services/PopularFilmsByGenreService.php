<?php

namespace Otus\Services;

use Otus\Dto\FilmOptionsDto;
use Otus\Exceptions\FilmsException;
use Otus\Interfaces\FilmRepositoryInterface;
use Otus\Interfaces\FilmServiceInterface;

class PopularFilmsByGenreService implements FilmServiceInterface
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
        $genresList = $optionsDto->getGenresList();

        if (!isset($genresList))
            throw new FilmsException(sprintf("Item by id genresList not found"));

        return $this->filmRepository->getPopularFilmsByGenre($genresList);
    }
}