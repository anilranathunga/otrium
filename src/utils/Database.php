<?php

namespace src\utils;

use Exception;
use \mysqli;
use src\configs\Config;

class Database
{
    private string $host = Config::DB_HOST;
    private int $port = Config::DB_PORT;
    private string $databaseName = Config::DB_NAME;
    private string $databaseUser = Config::DB_USER;
    private string $databasePassword = Config::DB_PASSWORD;

    private bool|null|object $connection = null;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->getConnection();
    }

    /**
     * @return object|bool
     */
    public function getConnection():object|bool
    {
        if ($this->connection){
            return $this->connection;
        }else{
            try {
                return new mysqli($this->host, $this->databaseUser, $this->databasePassword,$this->databaseName,$this->port);
            }catch (Exception $exception){
                echo $exception->getMessage();
                return false;
            }
        }
    }
}