<?php
use App\Helpers\Text;
use App\Model\Post;
use App\Model\Category;
use App\Connection;
use App\URL;
use App\PaginatedQuery;
// require '../vendor/autoload.php';

$title= 'The blog';
$pdo= Connection::getPDO();

// $currentpage= (int)($_GET['page']?? 1) ?: 1;
$currentpage= URL::getPositiveInt('page', 1);
if($currentpage< 0) {
	throw new Exception("Wrong page number");
}

$paginatedQuery= new PaginatedQuery(
	"SELECT* FROM post ORDER BY created_at DESC",
	"SELECT COUNT(id) FROM post"
);
$posts= $paginatedQuery->getItems(Post::class);
$postsByIds= [];
foreach ($posts as $post){
	$postsByIds[$post->getID()]= $post;
}
$categories= $pdo->query("SELECT c.*, pc.post_id
	FROM post_category pc
	JOIN category c ON c.id = pc.category_id
	WHERE pc.post_id IN (" . implode(', ', array_keys($postsByIds)) . ")"
)->fetchAll(PDO::FETCH_CLASS, Category::class);

foreach($categories as $category){
	$postsByIds[$category->getPostId()]->addCategory($category);
}

?>

<h1>Blog</h1>

<div class="row">
	<?php foreach ($posts as $post): ?>
	<div class="col-md-3">
		<?php require 'card.php' ?>
	</div>
	<?php endforeach ?>
</div>

<div class="g-flex bottom">
	
	<?= $paginatedQuery->previousLink($router->url('blog')) ?>
	<?= $paginatedQuery->nextLink($router->url('blog')) ?>

</div>