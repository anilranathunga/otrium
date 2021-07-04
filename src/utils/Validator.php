<?php


namespace src\utils;


use src\configs\Config;

class Validator
{
    /**
     * @var array
     * array item: "fieldName" => ["Field Label",["validationRule:anotherFieldNameIfNeededForRule",]]
     */
    protected array $rules;

    /**
     * @var array
     * * array item: "startDate" => '2018-05-01',
     */
    protected array $paraqmeters;

    public function __construct(array $rules, array $paraqmeters)
    {
        $this->rules = $rules;
        $this->paraqmeters = $paraqmeters;
    }

    /**
     * @param $value
     * @param $label
     * @return bool|string
     * validate string
     */
    public function string($value, $label): bool|string
    {
        if(is_string($value)){
            return true;
        }else{
            return "{$label} has to be string";
        }
    }

    /**
     * @param $date
     * @param $label
     * @return bool|string
     * Validate date
     */
    public function date($date, $label): bool|string
    {
        $format = Config::DATE_FORMAT;
        $d = \DateTime::createFromFormat($format, $date);

        if($d && $d->format($format) === $date){
            return true;
        }else{
            return $label. " has to be a valid date";
        }
    }

    /**
     * @param $date
     * @param $label
     * @param $otherParameter
     * @return bool|string
     * @throws \Exception
     * Compare two date fields
     */
    public function dateGreaterThan($date, $label, $otherParameter): bool|string
    {
        $otherParameterValue = $this->paraqmeters[$otherParameter];
        $otherParameterLabel = $this->rules[$otherParameter][0];
        $date = new \DateTime($date);
        $date2    = new \DateTime($otherParameterValue);

        if ($date > $date2) {
            return true;
        }else{
            return $label. " has to be greater than ".$otherParameterLabel;
        }
    }
}