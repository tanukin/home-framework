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

        if (!isset($fromAge))
            throw new FilmsException(sprintf("Item by id fromAge not found"));

        if (!isset($toAge))
            throw new FilmsException(sprintf("Item by id toAge not found"));

        if ($fromAge > $toAge)
            list($fromAge, $toAge) = [$toAge, $fromAge];

        return $filmRepository->getPopularFilmsByAgeRange($fromAge, $toAge);
    }
}