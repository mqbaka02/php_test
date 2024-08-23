<?php
namespace App\Validators;
use App\Validators\AbstractValidator;
use App\Table\CategoryTable;

class CategoryValidator extends AbstractValidator {

    public function __construct(array $data, CategoryTable $table, ?int $id= null) {
        parent::__construct($data);
        $this->validator->rule('required', ['name', 'slug']);
        $this->validator->rule('slug', ['slug']);
        $this->validator->rule('lengthBetween', ['name', 'slug'],3, 200);
        $this->validator->rule('regex', 'name', '/^[a-zA-Z\p{P}\s]+$/u');
        $this->validator->rule(function ($field, $value) use ($table, $id){
            return !($table->exists($field, $value, $id));
        }, 'slug', 'This slug is already used for another post');
        $this->validator->rule(function ($field, $value) use ($table, $id){
            return !($table->exists($field, $value, $id));
        }, 'name', 'This name is already used for another post');
    }
}