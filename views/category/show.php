<?php
use App\Connection;
use App\Model\Category;
use App\Model\Post;
use App\URL;
use App\PaginatedQuery;

$id= (int)$params['id'];
$slug= $params['slug'];

$pdo= Connection::getPDO();
$query= $pdo->prepare("SELECT * FROM category WHERE id = :id");
$query->execute(['id'=> $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
/**
 * @var Category|false
 */
$category= $query->fetch();

if($category=== false){
	throw new Exception("No category corresponding to the given id.");
}

if($category->getSlug()!== $slug){
	$url= $router->url('category', ['slug'=> $category->getSlug(), 'id'=> $id]);
	// dd($url);
	http_response_code(301);
	header('Location: ' . $url);
}
// dd($category);
$title= "Category {$category->getName()}";

$currentpage= URL::getPositiveInt('page', 1);
if($currentpage< 0) {
	throw new Exception("Wrong page number");
}

$paginatedQuery= new PaginatedQuery(
	"SELECT p.*
		FROM post p
		JOIN post_category pc on pc.post_id = p.id
		WHERE pc.category_id = " . $category->getID() .
		" ORDER BY created_at DESC",
	"SELECT COUNT(category_id) FROM post_category WHERE category_id = " . $category->getID()
);

/**
 * @var Post[]
 */
$posts= $paginatedQuery->getItems(Post::class);
// dd($posts);


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