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

        if (is_null($genresList))
            throw new FilmsException(sprintf("Value for key genresList isn't set"));

        $genresList = explode(',', $genresList);

        return $filmRepository->getPopularFilmsByGenre($genresList);
    }
}