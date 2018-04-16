<?php

namespace Otus\Services;

use Otus\Dto\FilmOptionsDto;
use Otus\Exceptions\FilmsException;
use Otus\Interfaces\FilmRepositoryInterface;
use Otus\Interfaces\FilmServiceInterface;

class PopularFilmsByGenreService implements FilmServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFilms(FilmRepositoryInterface $filmRepository, FilmOptionsDto $optionsDto): array
    {
        $genresList = $optionsDto->getGenresList();

        if (!isset($genresList))
            throw new FilmsException(sprintf("Item by id genresList not found"));

        return $filmRepository->getPopularFilmsByGenre($genresList);
    }
}