<?php
namespace App\HTML;

class Form {
    private $data;
    private $errors;

    public function __construct($data, array $errors) {
        $this->data= $data;
        $this->errors= $errors;
    }

    public function input(string $key, string $label): string {
        $value= $this->getValue($key);
        return <<<HTML
        <div class="form-grp">
            <label for="field{$key}">{$label}</label>
            <input type="text" id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" value="{$value}" required>
        </div>
HTML;
    }

    public function textarea(string $key, string $label): string {
        $value= $this->getValue($key);
        return <<<HTML
        <div class="form-grp">
            <label for="field{$key}">{$label}</label>
            <textarea type="text" id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" required>{$value}</textarea>
        </div>
HTML;
    }

    private function getValue(string $key) {
        if(is_array($this->data)){
            return $this->data[$key] ?? null;
        }
        $method= 'get' . ucfirst($key);
        return $this->data->$method();
    }

    private function getInputClass(string $key){
        $input_class= 'form-ctrl';
        $invalid_feedback= '';
        if(isset($this->errors[$key])){
            $input_class .= ' ' . 'is-invalid';
        }
        return $input_class;
    }
}