<?php


namespace src\utils;

use src\utils\Database;

class BaseModel
{

    private Database $database;

    /**
     * BaseModel constructor.
     */
    public function __construct()
    {
        $this->database = new Database();
    }

    /**
     * @param string $query
     * @return bool|object
     */
    public function query(string $query): bool|object
    {
        try {
            return $this->database->getConnection()->query($query);
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
        return false;
    }
}