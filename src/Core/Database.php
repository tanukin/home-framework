<?php

namespace Otus\Core;

class Database
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * Database constructor.
     *
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     * @param string $dbname
     */
    public function __construct(string $host, int $port, string $username, string $password, string $dbname)
    {
        $this->pdo = new \PDO("pgsql:host=$host;port=$port;dbname=$dbname;", $username, $password, null);
        var_dump($this->pdo);
        exit;
    }

    /**
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
}