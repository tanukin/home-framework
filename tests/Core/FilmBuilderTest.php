<?php

use Otus\Core\FilmBuilder;
use Otus\Entities\Film;
use PHPUnit\Framework\TestCase;

class FilmBuilderTest extends TestCase
{
    private $data = [
        'id' => 1,
        'title' => 'title',
        'release_date' => '2018-04-18'
    ];

    public function testShould_ReturnFilm_When_CorrectData()
    {
        $filmBuilder = new FilmBuilder();

        $this->assertEquals($this->createFilm(), $filmBuilder->getFilm($this->data));
    }


    private function createFilm():Film
    {
        return new Film($this->data['id'], $this->data['title'], $this->data['release_date']);
    }

}