<?php
use App\Connection;
use App\Model\Post;
use App\Model\Category;
use App\Table\PostTable;
use App\Table\CategoryTable;

$id= (int)$params['id'];
$slug= $params['slug'];

$pdo= Connection::getPDO();
$post= (new PostTable($pdo))->find($id);
(new CategoryTable($pdo))->hydratePosts([$post]);

// $query= $pdo->prepare("SELECT * FROM post WHERE id = :id");
// $query->execute(['id'=> $id]);
// $query->setFetchMode(PDO::FETCH_CLASS, Post::class);
// $post= $query->fetch();


if($post=== false){
	throw new Exception("No article corresponding to the given id.");	
}

if($post->getSlug()!== $slug){
	$url= $router->url('post', ['slug'=> $post->getSlug(), 'id'=> $id]);
	
	http_response_code(301);
	header('Location: ' . $url);
}

?>
<div class="title-container">
	<h1 class="card-title"><?= htmlentities($post->getName()) ?></h1>
	<p class="txt-muted"><?= $post->getCreatedAt()->format('d F Y H:i') ?></p>
	<div class="labels">
		<?php if($post->getCategories()!== null): ?>
			<?php foreach ($post->getCategories() as $key=> $category): ?>
				<a class="category-label" href="<?= $router->url('category', ['id'=> $category->getID(), 'slug'=> $category->getSlug()]) ?>">
					<?= htmlentities($category->getName()) ?>
				</a>
			<?php endforeach ?>
		<?php endif ?>
	</div>
</div>
<p class="p-content"><?= $post->getFormattedContent() ?></p>