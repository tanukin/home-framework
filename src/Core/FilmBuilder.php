<?php

namespace Otus\Core;

use Otus\Entities\Film;

class FilmBuilder
{
    /**
     * @param array $data
     *
     * @return Film
     */
    public function getFilm(array $data): Film
    {
        return new Film($data['id'], $data['title'], $data['release_date']);
    }
}