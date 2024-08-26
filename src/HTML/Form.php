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
        $type= ($key=== "password")? "password" : "text";
        return <<<HTML
        <div class="form-grp">
            <label for="field{$key}">{$label}</label>
            <input type= {$type} id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" value="{$value}" required>
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

    private function getValue(string $key): ?string {
        if(is_array($this->data)){
            return $this->data[$key] ?? null;
        }
        $method= 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
        $value= $this->data->$method();
        if ($value instanceof \DateTimeInterface){
            return $value->format("Y-m-d H:i:s");
        }
        return $value;
    }

    private function getInputClass(string $key){
        $input_class= 'form-ctrl';
        if(isset($this->errors[$key])){
            $input_class .= ' ' . 'is-invalid';
        }
        return $input_class;
    }
}