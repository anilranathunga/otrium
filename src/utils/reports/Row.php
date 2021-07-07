<?php

namespace src\utils\reports;

use src\configs\Config;

/**
 * Class Row
 * @package src\utils\reports
 * data cleaning and formatting class
 */
class Row
{
    /**
     * @var array
     * One row of database result
     * All the alterations will be done here to the data
     */
    private array $data;

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Row constructor.
     * @param $dbResultRow
     */
    public function __construct($dbResultRow = [])
    {
        $this->data = $dbResultRow;
    }

    /**
     * use $fieldNames array to remove tax from all except certain fields
     * remove tax and update $data variable
     * @param array $fieldNames
     */
    public function removeTaxExcept(array $fieldNames): void
    {
        if (sizeof($this->data)==0){
            return;
        }

        $recordsWithoutTax = [];

        foreach ($this->data as $key=>$value) {
            if ( in_array($key,$fieldNames) ) {
                $recordsWithoutTax[$key] = $value;
            } else {
                $recordsWithoutTax[$key] = $this->removeTax($value);
            }
        }
        $this->data = $recordsWithoutTax;
    }

    /**
     * use $fieldNames array only to remove tax from certain fields
     * @param array $fieldNames
     * remove tax and update $data variabale
     */
    public function removeTaxOnlyIn(array $fieldNames): void
    {
        if (sizeof($this->data)==0){
            return;
        }
        $recordsWithoutTax = [];
        foreach ($this->data as $key=>$value) {
            if ( in_array($key,$fieldNames) ) {
                $recordsWithoutTax[$key] = $this->removeTax($value);
            } else {
                $recordsWithoutTax[$key] = $value;
            }
        }
        $this->data = $recordsWithoutTax;
    }

    public function removeTax($value): string
    {
        $value>0 ? ($value -= ($value * (Config::TAX_RATE / (100 + Config::TAX_RATE)))): 0;
        return number_format($value, 2);
    }

    /**
     * get column headers in human readable format
     */
    public function getHeaders(): array
    {
        $headers = [];
        foreach ($this->data as $field=>$value){
            $headers[] = ucwords(str_replace("_"," ",$field));
        }
        return $headers;
    }
}