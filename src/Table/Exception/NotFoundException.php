<?php
namespace App\Table\Exception;

class NotFoundException extends \Exception{
    public function __construct(string $table, int $id){
        $this->message= "No reccord matches the id #$id in the table '$table'.";
    }
}