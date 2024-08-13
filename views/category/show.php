<?php
use App\Connection;
use App\Model\{Category, Post};
use App\URL;
use App\PaginatedQuery;
use App\Table\CategoryTable;
use App\Table\PostTable;

$id= (int)$params['id'];
$slug= $params['slug'];

$pdo= Connection::getPDO();
// $categoryTable= new CategoryTable($pdo);
$category= (new CategoryTable($pdo))->find($id);
// $category= $categoryTable->find($id);

if($category->getSlug()!== $slug){
	$url= $router->url('category', ['slug'=> $category->getSlug(), 'id'=> $id]);
	// dd($url);
	http_response_code(301);
	header('Location: ' . $url);
}

$title= "Category {$category->getName()}";

[$posts, $paginatedQuery]= (new PostTable($pdo))->findPaginatedForCategory($category->getID());

$currentpage= URL::getPositiveInt('page', 1);
if($currentpage< 0) {
	throw new Exception("Wrong page number");
}

// $paginatedQuery= new PaginatedQuery(
// 	"SELECT p.*
// 		FROM post p
// 		JOIN post_category pc on pc.post_id = p.id
// 		WHERE pc.category_id = " . $category->getID() .
// 		" ORDER BY created_at DESC",
// 	"SELECT COUNT(category_id) FROM post_category WHERE category_id = " . $category->getID()
// );

// /**
//  * @var Post[]
//  */
// $posts= $paginatedQuery->getItems(Post::class);
// // dd($posts);


// $postsByIds= [];
// foreach ($posts as $post){
// 	$postsByIds[$post->getID()]= $post;
// }
// $categories= $pdo->query("SELECT c.*, pc.post_id
// 	FROM post_category pc
// 	JOIN category c ON c.id = pc.category_id
// 	WHERE pc.post_id IN (" . implode(', ', array_keys($postsByIds)) . ")"
// )->fetchAll(PDO::FETCH_CLASS, Category::class);

// foreach($categories as $category){
// 	$postsByIds[$category->getPostId()]->addCategory($category);
// }

$link= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);

?>
<h1><?= htmlentities($title) ?></h1>

<div class="row">
	<?php foreach ($posts as $post): ?>
	<div class="col-md-3">
		<?php require dirname(__DIR__) . '/post/card.php' ?>
	</div>
	<?php endforeach ?>
</div>

<div class="g-flex">
		<?= $paginatedQuery->previousLink($link) ?>
		<?= $paginatedQuery->nextLink($link) ?>

</div>