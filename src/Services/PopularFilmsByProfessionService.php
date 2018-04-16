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

        if (is_null($professionsList))
            throw new FilmsException(sprintf("Value for key professionsList isn't set"));

        $professionsList = explode(',', $professionsList);

        return $filmRepository->getPopularFilmsByProfession($professionsList);
    }
}