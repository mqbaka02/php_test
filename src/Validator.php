<?php
namespace App;
use Valitron\Validator as V_Validator;

class Validator extends V_Validator{
    protected function checkAndSetLabel($field, $message, $params)
    {
        return str_replace('{field}', '', $message);
    }
}