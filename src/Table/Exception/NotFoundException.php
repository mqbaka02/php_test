<?php
namespace App\Table\Exception;

class NotFoundException extends \Exception{
    public function __construct(string $table, $id){
        $this->message= "No reccord matches #$id in the table '$table'.";
    }
}