<?php


namespace src\models;
use src\utils\BaseModel;

class Brand extends BaseModel
{
    public static string $tableName = "brands";

    public function getAllBrandNames(): object
    {
        $tableName= self::$tableName;
        return $this->query("select name from {$tableName}");
    }
}