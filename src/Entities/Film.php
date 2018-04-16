<?php

namespace Otus\Entities;

use Otus\Interfaces\FilmInterface;

class Film implements FilmInterface
{
    /**
     * @var int
     */

    private $id;
    /**
     * @var string
     */

    private $title;

    /**
     * @var string
     */
    private $realiseDate;

    /**
     * Film constructor.
     *
     * @param int $id
     * @param string $title
     * @param string $realiseDate
     */
    public function __construct(int $id, string $title, string $realiseDate)
    {
        $this->id = $id;
        $this->title = $title;
        $this->realiseDate = $realiseDate;
    }

    /**
     * Returns id of this film
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns title of this film
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns release date of this film
     *
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->realiseDate;
    }
}