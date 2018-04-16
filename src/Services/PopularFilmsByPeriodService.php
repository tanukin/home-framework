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

        if (!isset($fromYear))
            throw new FilmsException(sprintf("Item by id fromYear not found"));

        if (!isset($toYear))
            throw new FilmsException(sprintf("Item by id toYear not found"));

        if ($fromYear > $toYear)
            list($fromYear, $toYear) = [$toYear, $fromYear];

        return $filmRepository->getPopularFilmsByPeriod($fromYear, $toYear);
    }
}