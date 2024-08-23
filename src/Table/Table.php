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

    /**
     * Checks the existence of a value in the database
     * @param string $field field to search for
     * @param string $value value of the field
     */
    public function exists(string $field, $value, ?int $except= null): bool {
        $sql= "SELECT COUNT(id) FROM {$this->table} WHERE $field = ?";
        $params= [$value];
        if($except!== null){
            $sql .= " AND id!= ?";
            $params[]= $except;
        }
        $query= $this->pdo->prepare($sql);
        $query->execute($params);
        return (int)($query->fetch(PDO::FETCH_NUM)[0] > 0);
    }

    public function all(): array{
        $sql=  "SELECT * FROM {$this->table}";
        $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
    }

    public function delete(int $id) {
        $query= $this->pdo->prepare("DELETE FROM " . $this->table . " WHERE id= ?");
        $ok= $query->execute([$id]);
        if($ok=== false){
            throw new \Exception("Can't delete $id from the table {$this->table}.");
        }
    }

    public function create(array $data): int {
        $sqlFields= [];
        foreach($data as $key=> $value){
            $sqlFields[]= "$key = :$key";
        }
        $query= $this->pdo->prepare("INSERT INTO {$this->table} SET " . implode(', ', $sqlFields));
        $ok= $query->execute($data);
        if($ok=== false){
            throw new \Exception("Can't create new entry in the table {$this->table}.");
        }
        return (int)($this->pdo->lastInsertID());
    }

    public function update(Post $post){
        $sqlFields= [];
        foreach($data as $key=> $value){
            $sqlFields[]= "$key = :$key";
        }
        $query= $this->pdo->prepare("INSERT INTO {$this->table} SET " . implode(', ', $sqlFields) . " WHERE id= :id");
        $ok= $query->execute(array_merge($data, ['id'=> $id]));
        if($ok=== false){
            throw new \Exception("Can't write changes in the table {$this->table}.");
        }
    }
}