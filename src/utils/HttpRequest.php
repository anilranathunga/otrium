<?php


namespace src\utils;


use http\Encoding\Stream\Deflate;

class HttpRequest
{

    protected array $parameters;


    public function __construct()
    {
        $this->setParameters();
    }

    public function setParameters()
    {
        $parameters = [];
        switch ($_SERVER["REQUEST_METHOD"]){
            case "POST":
                $parameters = $_POST;
                break;
            case "GET":
                $parameters = $_GET;
                break;
        }
        $this->parameters = $parameters;
        return $this;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function validate(array $rules)
    {
        $errors = [];
        $validator = new Validator($rules,$this->parameters);

        foreach ($rules as $parameter => $validations){
            $label = $validations[0];
            $validationRules = $validations[1];

            //go and run each validation rule
            foreach ($validationRules as $validatorRule){

                // if validate rule contains any validation with other param, separate it and validation rule
                $validatorRule = explode(":",$validatorRule);
                $validatorName = $validatorRule[0];

                $status = false;
                if (sizeof($validatorRule)>1){
                    $validateWith = $validatorRule[1];
                    $status = $validator->$validatorName($this->parameters[$parameter] ,$label, $validateWith);
                }else{
                    $status = $validator->$validatorName($this->parameters[$parameter] ,$label);
                }
                if ($status!==true){
                    $errors[] = $status;
                    Session::setFlash("error",$status);
                }
            }
        }
        return sizeof($errors)>0 ? $errors : true;
    }
}