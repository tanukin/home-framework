<?php

namespace Otus\Services;

use Otus\Dto\FilmOptionsDto;
use Otus\Exceptions\FilmsException;
use Otus\Interfaces\FilmRepositoryInterface;
use Otus\Interfaces\FilmServiceInterface;

class PopularFilmsByPeriodService implements FilmServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFilms(FilmRepositoryInterface $filmRepository, FilmOptionsDto $optionsDto): array
    {
        $fromYear = $optionsDto->getFromYear();
        $toYear = $optionsDto->getToYear();

        if ($fromYear < 0)
            throw new FilmsException(sprintf("Value for key fromYear isn't set"));

        if ($toYear < 0)
            throw new FilmsException(sprintf("Value for key toYear isn't set"));

        if ($fromYear > $toYear)
            list($fromYear, $toYear) = [$toYear, $fromYear];

        return $filmRepository->getPopularFilmsByPeriod($fromYear, $toYear);
    }
}