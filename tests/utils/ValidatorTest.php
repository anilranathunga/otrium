<?php


namespace Tests\utils;


use phpDocumentor\Reflection\Types\Object_;
use PHPUnit\Framework\TestCase;
use src\utils\Validator;

class ValidatorTest extends TestCase
{
    protected Validator $validator;

    protected function setUp(): void
    {
        $rules = [
            "name" => ["Name",["string"]],
            "startDate" => ["Start Date",["string"]],
            "endDate" => ["End Date",["string",]]
        ];

        $parameters = [
            "name" => "John",
            "startDate" => '2018-05-01',
            "endDate" => '2018-05-07'
        ];


        $this->validator = new Validator($rules, $parameters);
    }
    public function test_it_validate_string()
    {
        $result = $this->validator->string("John","Name");

        $this->assertTrue($result);
    }

    public function test_it_validate_string_with_int()
    {
        $result = $this->validator->string(2112,"Name");

        $this->assertEquals("Name has to be string" ,$result);
    }

    /**
     * @dataProvider dateGreaterThanValidator
     */
    public function test_it_validates_that_given_date_is_greater_than_the_other($input, $expected)
    {
        $result = $this->validator->dateGreaterThan($input["endDateValue"],$input["label"],$input["otherDateParam"]);

        $this->assertEquals($expected, $result);
    }

    public function dateGreaterThanValidator(): array
    {
        return [
            [["endDateValue"=>"2018-04-01","label"=>"End Date","otherDateParam"=>"startDate"],"End Date has to be greater than Start Date"],
            [["endDateValue"=>"2018-05-08","label"=>"End Date","otherDateParam"=>"startDate"],true]
        ];
    }
}