<?php

namespace Otus\Core;

class Database
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $dbname;

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
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    /**
     * @return \PDO
     *
     * @throws \Exception
     */
    public function getPdo(): \PDO
    {
        $dsn = "pgsql:host=$this->host;port=$this->port;dbname=$this->dbname;user=$this->username;password=$this->password";

        try{
            $this->pdo = new \PDO($dsn);
        }catch (\PDOException $e){
            throw new \Exception($e);
        }

        return $this->pdo;
    }
}