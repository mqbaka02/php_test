<?php
use App\Connection;
use App\Model\Post;
use App\Model\Category;

$id= (int)$params['id'];
$slug= $params['slug'];

$pdo= Connection::getPDO();
$query= $pdo->prepare("SELECT * FROM post WHERE id = :id");
$query->execute(['id'=> $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Post::class);
$post= $query->fetch();


if($post=== false){
	throw new Exception("No article corresponding to the given id.");	
}

if($post->getSlug()!== $slug){
	$url= $router->url('post', ['slug'=> $post->getSlug(), 'id'=> $id]);
	// dd($url);
	http_response_code(301);
	header('Location: ' . $url);
}

$query= $pdo->prepare("
	SELECT c.id, c.slug, c.name
	FROM post_category pc
	JOIN category c ON pc.category_id= c.id
	WHERE pc.post_id = :id");

$query->execute(['id'=> $post->getId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
$categories= $query->fetchAll();
// dd($categories);

?>
<div class="title-container">
	<h1 class="card-title"><?= htmlentities($post->getName()) ?></h1>
	<p class="txt-muted"><?= $post->getCreatedAt()->format('d F Y H:i') ?></p>
	<div class="labels">
		<?php foreach ($categories as $key=> $category): ?>
			<a class="category-label" href="<?= $router->url('category', ['id'=> $category->getID(), 'slug'=> $category->getSlug()]) ?>">
				<?= htmlentities($category->getName()) ?>
			</a>
		<?php endforeach ?>
	</div>
</div>
<p class="p-content"><?= $post->getFormattedContent() ?></p>