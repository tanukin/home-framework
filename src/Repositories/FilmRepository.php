<?php

namespace Otus\Repositories;

use Otus\Interfaces\FilmRepositoryInterface;

class FilmRepository implements FilmRepositoryInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * FilmRepository constructor.
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularFilmsByGenre(array $genresList): array
    {
        $genresList = $this->getListCriteriaFromArray($genresList);

        $sql = "
            SELECT
              movies.id,
              movies.title,
              movies.release_date              
            FROM ratings
              INNER JOIN movies ON ratings.movie_id = movies.id
              INNER JOIN genres_movies ON ratings.movie_id =  genres_movies.movie_id
              INNER JOIN genres ON genres_movies.genre_id = genres.id
            WHERE genres.name IN ($genresList)
            GROUP BY movies.id
            ORDER BY AVG(rating) DESC
            LIMIT 200;
            ";

        $sth = $this->pdo->query($sql);

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularFilmsByProfession(array $professionsList): array
    {
        $professionsList = $this->getListCriteriaFromArray($professionsList);

        $sql = "
        SELECT
          movies.id,
          movies.title,
          movies.release_date
        FROM ratings
          INNER JOIN movies ON ratings.movie_id = movies.id
          INNER JOIN users ON ratings.user_id = users.id
          INNER JOIN occupations ON users.occupation_id = occupations.id
        WHERE occupations.name IN ($professionsList)
        GROUP BY movies.id
        ORDER BY AVG(rating) DESC
        LIMIT 50;
        ";

        $sth = $this->pdo->query($sql);

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularFilmsByAgeRange(int $fromAge, int $toAge): array
    {
        $sql = '
        SELECT
          movies.id,
          movies.title,
          movies.release_date 
        FROM ratings
          INNER JOIN movies ON ratings.movie_id = movies.id
          INNER JOIN users ON ratings.user_id = users.id
        WHERE users.age BETWEEN :from AND :to
        GROUP BY movies.id
        ORDER BY AVG(rating) ASC
        LIMIT 200;
        ';

        $sth = $this->pdo->prepare($sql);
        $sth->execute([':from' => $fromAge, ':to' => $toAge]);

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularFilmsByPeriod(int $fromYear, int $toYear): array
    {
        $sql = "
        SELECT
          movies.id,
          movies.title,
          movies.release_date 
        FROM ratings
          INNER JOIN movies ON ratings.movie_id = movies.id
          INNER JOIN users ON ratings.user_id = users.id
        WHERE users.gender = 'F' AND (date_part('year', movies.release_date) BETWEEN $fromYear AND $toYear)
        GROUP BY movies.id
        ORDER BY AVG(rating) DESC
        LIMIT 200;
        ";

        $sth = $this->pdo->query($sql);

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get list of criteria from an array
     *
     * @param array $criteria
     *
     * @return string
     */
    private function getListCriteriaFromArray(array $criteria): string
    {
        $arr = array_map(function ($item) {
            return $this->pdo->quote($item);
        }, $criteria);

        return implode(',', $arr);
    }
}