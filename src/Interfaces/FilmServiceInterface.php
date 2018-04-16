<?php

namespace Otus\Interfaces;

use Otus\Dto\FilmOptionsDto;
use Otus\Exceptions\FilmsException;

interface FilmServiceInterface
{
    /**
     * Returns array popular films by options
     *
     * @param FilmOptionsDto $optionsDto
     *
     * @return array
     *
     * @throws FilmsException
     */
    public function getFilms(FilmOptionsDto $optionsDto): array;
}