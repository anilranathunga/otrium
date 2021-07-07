<?php


namespace Tests\utils;


use PHPUnit\Framework\TestCase;
use src\configs\Config;
use src\utils\BaseModel;
use src\utils\reports\Row;
use src\models\Gmv;

class RowTest   extends TestCase
{
    protected Row $row;

    protected function setUp(): void
    {
        //$gmv = new Gmv();
        $dataBaseRecordArray = [
            "brand_a" => 100+Config::TAX_RATE,
            "brand_b" => 100+Config::TAX_RATE,
            "brand_c" => 100+Config::TAX_RATE
        ];
        $this->row = new Row($dataBaseRecordArray);
    }

    public function test_it_calculates_tax()
    {
        $amountWithTax = 100+Config::TAX_RATE;
        $amountWithoutTax = 100;
        $result = $this->row->removeTax($amountWithTax);
        $this->assertEquals($amountWithoutTax,$result);
    }

    public function test_it_remove_tax_only_passed_fields()
    {
        $fieldsToRemoveTax=["brand_a"];
        $this->row->removeTaxOnlyIn($fieldsToRemoveTax);
        $processedData = $this->row->getData();

        $expectedData = [
            "brand_a" => 100,
            "brand_b" => 100+Config::TAX_RATE,
            "brand_c" => 100+Config::TAX_RATE
        ];

        $this->assertEquals($processedData,$expectedData);
    }

    public function test_it_remove_tax_on_all_except_passed_fields()
    {
        $fieldsNotToRemoveTax = ["brand_a"];
        $this->row->removeTaxExcept($fieldsNotToRemoveTax);
        $processedData = $this->row->getData();

        $expectedData = [
            "brand_a" => 100+Config::TAX_RATE,
            "brand_b" => 100,
            "brand_c" => 100
        ];

        $this->assertEquals($processedData,$expectedData);
    }

    public function test_it_get_column_headers_in_human_readable_format()
    {
        $result = $this->row->getHeaders();

        $expected = ["Brand A","Brand B","Brand C"];

        $this->assertEquals($result,$expected);
    }
}