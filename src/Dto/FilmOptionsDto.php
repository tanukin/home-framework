<?php

namespace Otus\Dto;

class FilmOptionsDto
{
    /**
     * @var array
     */
    private $genresList;

    /**
     * @var array
     */
    private $professionsList;

    /**
     * @var int
     */
    private $fromAge;

    /**
     * @var int
     */
    private $toAge;

    /**
     * @var int
     */
    private $fromYear;

    /**
     * @var int
     */
    private $toYear;

    /**
     * @return array
     */
    public function getGenresList(): array
    {
        return $this->genresList;
    }

    /**
     * @param string $genresList
     */
    public function setGenresList(string $genresList): void
    {
        $this->genresList = explode(',', $genresList);
    }

    /**
     * @return array
     */
    public function getProfessionsList(): array
    {
        return $this->professionsList;
    }

    /**
     * @param string $professionsList
     */
    public function setProfessionsList(string $professionsList): void
    {
        $this->professionsList = explode(',', $professionsList);
    }

    /**
     * @return int
     */
    public function getFromAge(): int
    {
        return $this->fromAge;
    }

    /**
     * @param int $fromAge
     */
    public function setFromAge(int $fromAge): void
    {
        $this->fromAge = $fromAge;
    }

    /**
     * @return int
     */
    public function getToAge(): int
    {
        return $this->toAge;
    }

    /**
     * @param int $toAge
     */
    public function setToAge(int $toAge): void
    {
        $this->toAge = $toAge;
    }

    /**
     * @return int
     */
    public function getFromYear(): int
    {
        return $this->fromYear;
    }

    /**
     * @param int $fromYear
     */
    public function setFromYear(int $fromYear): void
    {
        $this->fromYear = $fromYear;
    }

    /**
     * @return int
     */
    public function getToYear(): int
    {
        return $this->toYear;
    }

    /**
     * @param int $toYear
     */
    public function setToYear(int $toYear): void
    {
        $this->toYear = $toYear;
    }
}