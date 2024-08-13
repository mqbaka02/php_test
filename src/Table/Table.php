<?php
namespace App\Table;
use App\Model\Post;
use \PDO;

abstract class Table{

    protected $pdo;
    protected $table= null;
    protected $class= null;

    public function __construct(PDO $pdo){
        if($this->table=== null){
            throw new \Exception("The class' table property " . get_class($this) . " is undefined.");
        }
        if($this->class=== null){
            throw new \Exception("The class' class property " . get_class($this) . " is undefined.");
        }
        $this->pdo= $pdo;
    }

    public function find(int $id){
        $query= $this->pdo->prepare("SELECT * FROM " . $this->table . " WHERE id = :id");
        $query->execute(['id'=> $id]);
        // dd($this->table);
        // dd(Post::class);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result= $query->fetch();
        if($result=== false){
            throw new NotFoundException($this->table, $id);
        }
        return $result;
    }
}