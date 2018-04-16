<?php

namespace Otus\Dto;

class FilmOptionsDto
{
    /**
     * @var null|string
     */
    private $genresList;

    /**
     * @var null|string
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
     * @return null|string
     */
    public function getGenresList(): ?string
    {
        return $this->genresList;
    }

    /**
     * @param null|string $genresList
     */
    public function setGenresList($genresList): void
    {
        $this->genresList = $genresList;
    }

    /**
     * @return null|string
     */
    public function getProfessionsList(): ?string
    {
        return $this->professionsList;
    }

    /**
     * @param null|string $professionsList
     */
    public function setProfessionsList($professionsList): void
    {
        $this->professionsList = $professionsList;
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