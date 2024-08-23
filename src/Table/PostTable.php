<?php
namespace App\Table;
use App\Table\CategoryTable;
use App\PaginatedQuery;
use App\Model\Post;
use App\Model\Category;
use \PDO;

class PostTable extends Table{

    protected $table= 'post';
    protected $class= Post::class;

    public function findPaginated(){
        $paginatedQuery= new PaginatedQuery(
            "SELECT* FROM {$this->table} ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM {$this->table}",
            $this->pdo
        );
        $posts= $paginatedQuery->getItems(Post::class);
        
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

    public function findPaginatedForCategory($categoryID){
        $paginatedQuery= new PaginatedQuery(
            "SELECT p.*
                FROM {$this->table} p
                JOIN post_category pc on pc.post_id = p.id
                WHERE pc.category_id = " . $categoryID .
                " ORDER BY created_at DESC",
            "SELECT COUNT(category_id) FROM post_category WHERE category_id = " . $categoryID
        );

        $posts= $paginatedQuery->getItems(Post::class);

        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

    public function updatePost(Post $post){
        $query= $this->pdo->prepare("UPDATE " . $this->table . " SET name= :name, slug= :slug, created_at= :created, content= :content WHERE id= :id");
        $ok= $this->update([
            'id'=> $post->getID(),
            'name'=> $post->getName(),
            'slug'=> $post->getSlug(),
            'content'=> $post->getContent(),
            'created'=> $post->getCreatedAt()->format('Y-m-d H:i:s')
        ], $post->getID());
        if($ok=== false){
            throw new \Exception("Can't delete $id from the table {$this->table}.");
        }
    }

    public function createPost(Post $post){
        $id= $this->create([
            'name'=> $post->getName(),
            'slug'=> $post->getSlug(),
            'content'=> $post->getContent(),
            'created'=> $post->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        $post->setID($id);
    }
}