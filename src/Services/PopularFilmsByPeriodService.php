<?php

namespace Otus\Services;

use Otus\Dto\FilmOptionsDto;
use Otus\Exceptions\FilmsException;
use Otus\Interfaces\FilmRepositoryInterface;
use Otus\Interfaces\FilmServiceInterface;

class PopularFilmsByPeriodService implements FilmServiceInterface
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
        $fromYear = $optionsDto->getFromYear();
        $toYear = $optionsDto->getToYear();

        if (!isset($fromYear))
            throw new FilmsException(sprintf("Item by id fromYear not found"));

        if (!isset($toYear))
            throw new FilmsException(sprintf("Item by id toYear not found"));

        if ($fromYear > $toYear)
            list($fromYear, $toYear) = [$toYear, $fromYear];

        return $this->filmRepository->getPopularFilmsByPeriod($fromYear, $toYear);
    }
}