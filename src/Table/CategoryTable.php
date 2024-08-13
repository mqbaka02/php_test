<?php
namespace App\Table;
use App\Table\Exception\NotFoundException;
use App\Model\Category;
use \PDO;

class CategoryTable extends Table{
    protected $table= 'category';
    protected $class= Category::class;

    /**
     * @param App\Model\Post[] $posts
     */
    public function hydratePosts(array $posts): void{
        $postsByIds= [];
        foreach ($posts as $post){
            $postsByIds[$post->getID()]= $post;
        }
        $categories= $this->pdo->query("SELECT c.*, pc.post_id
            FROM post_category pc
            JOIN category c ON c.id = pc.category_id
            WHERE pc.post_id IN (" . implode(', ', array_keys($postsByIds)) . ")"
        )->fetchAll(PDO::FETCH_CLASS, Category::class);

        foreach($categories as $category){
            $postsByIds[$category->getPostId()]->addCategory($category);
        }
    }
}