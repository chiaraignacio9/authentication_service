<?php

namespace App\libs;

class Validation
{

    protected $fields;

    public $errors = [];

    public function validate($data)
    {        

        foreach ($this->fields as $field => $validations) {

            if (str_contains($validations, '|')) {
                $validationsParts = explode('|', $validations);

                foreach ($validationsParts as $validation) {

                    if (str_contains($validation, ':')) {
                        $function = explode(':', $validation);
                        $this->{$function[0]}($function[1], $data->{$field}, $field);
                        continue;
                    }

                    if( $validation == 'repassword' ){
                        $this->repassword($data->password, $data->repassword, $field);
                        continue;
                    }

                    $this->{$validation}($data->{$field}, $field);
                }
                continue;
            }

            $this->{$validations}($data->{$field}, $field);
        }
    }

    public function hasErrors() :bool{

        if( count($this->errors) > 0 ){
            return true;
        }

        return false;

    }    

    private function repassword($password, $repassword, $field){

        if ($password !== $repassword) {
            $this->errors[$field][] = "Password do not match";
        }

    }

    private function max($maxLenght, $value, $field)
    {
        if (strlen($value) > $maxLenght) {
            $this->errors[$field][] = "The maximum characters to {$field} is {$maxLenght}";
        }
    }

    private function min($minLenght, $value, $field)
    {
        if (strlen($value) < $minLenght) {
            $this->errors[$field][] = "The minimum characters to {$field} is {$minLenght}";
        }
    }

    private function numeric($value, $field)
    {
        if (!preg_match('#^[0-9]+$#', $value)) {
            $this->errors[$field][] = "The {$field} must be an number";
        }
    }

    private function required($value, $field)
    {        
        if ((is_null($value)) || !(isset($value)) || strlen($value) == 0 ) {
            $this->errors[$field][] = "The {$field} is required";
        }
    }

    private function string($value, $field)
    {
        if (!preg_match('#^[a-zA-Z\s]+$#', $value)) {
            $this->errors[$field][] = "The {$field} must be contains only letters";
        }
    }

    private function email($value, $field)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "The {$field} is invalid";
        }
    }
}
