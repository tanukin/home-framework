<?php

namespace Otus\Services;

use Otus\Dto\FilmOptionsDto;
use Otus\Exceptions\FilmsException;
use Otus\Interfaces\FilmRepositoryInterface;
use Otus\Interfaces\FilmServiceInterface;

class PopularFilmsByAgeRangeService implements FilmServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFilms(FilmRepositoryInterface $filmRepository, FilmOptionsDto $optionsDto): array
    {
        $fromAge = $optionsDto->getFromAge();
        $toAge = $optionsDto->getToAge();

        if ($fromAge < 0)
            throw new FilmsException(sprintf("Value for key fromAge isn't set"));

        if ($toAge < 0)
            throw new FilmsException(sprintf("Value for key toAge isn't set"));

        if ($fromAge > $toAge)
            list($fromAge, $toAge) = [$toAge, $fromAge];

        return $filmRepository->getPopularFilmsByAgeRange($fromAge, $toAge);
    }
}