<?php

namespace src\models;

use src\models\Brand;
use src\utils\BaseModel;

class Gmv extends BaseModel
{
     public static string $tableName = "gmv";

    /**
     * @param string $startDate
     * @param string $endDate
     * @return object
     */
    public function getTotalTurnOverPerBrandDaily(string $startDate, string $endDate): object|bool
    {
        $brand = new Brand();
        $brands = $brand->getAllBrandNames();

        $gmvTableName = self::$tableName;
        $brandsTableName = Brand::$tableName;

        $brandsQueryFragment = "";
        foreach ($brands as $key=>$brand){

            if ($key == $brands->num_rows-1){
                $brandsQueryFragment .= " sum(case when b.name='{$brand['name']}' then turnover end) as '{$brand['name']}' ";
            }else{
                $brandsQueryFragment .= " sum(case when b.name='{$brand['name']}' then turnover end) as '{$brand['name']}' ,";
            }
        }

        $query = "select DATE_FORMAT(date, '%Y-%m-%d') as Date, $brandsQueryFragment 
                from {$gmvTableName} right join {$brandsTableName} b on b.id = gmv.brand_id 
                where date between '{$startDate }'  and '{$endDate}' 
                group by date";

        return $this->query($query);
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @return object
     */
    public function getTotalTurnOverDaily(string $startDate, string $endDate): object|bool
    {
        $gmvTableName = self::$tableName;
        $brandsTableName = Brand::$tableName;

        $query = "select DATE_FORMAT(date, '%Y-%m-%d') as Date, 
        sum(turnover) as 'Total_TO'
        from {$gmvTableName} right join {$brandsTableName} b on b.id = gmv.brand_id 
        where date between '{$startDate}' and '{$endDate}' group by date";

        return $this->query($query);
    }
}