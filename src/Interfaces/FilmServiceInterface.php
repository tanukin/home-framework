<?php

namespace Otus\Interfaces;

use Otus\Dto\FilmOptionsDto;
use Otus\Exceptions\FilmsException;

interface FilmServiceInterface
{
    /**
     * Returns array popular films by options
     *
     * @param FilmRepositoryInterface $filmRepository
     * @param FilmOptionsDto $optionsDto
     *
     * @return array
     */
    public function getFilms(FilmRepositoryInterface $filmRepository, FilmOptionsDto $optionsDto): array;
}