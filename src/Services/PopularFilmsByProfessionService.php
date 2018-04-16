<?php

namespace Otus\Services;

use Otus\Dto\FilmOptionsDto;
use Otus\Exceptions\FilmsException;
use Otus\Interfaces\FilmRepositoryInterface;
use Otus\Interfaces\FilmServiceInterface;

class PopularFilmsByProfessionService implements FilmServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFilms(FilmRepositoryInterface $filmRepository, FilmOptionsDto $optionsDto): array
    {
        $professionsList = $optionsDto->getProfessionsList();

        if (!isset($professionsList))
            throw new FilmsException(sprintf("Item by id professionsList not found"));

        return $filmRepository->getPopularFilmsByProfession($professionsList);
    }
}