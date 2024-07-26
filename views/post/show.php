<?php
use App\Connection;
use App\Model\Post;

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

?>
<h1 class="card-title"><?= htmlentities($post->getName()) ?></h1>
<p class="txt-muted"><?= $post->getCreatedAt()->format('d F Y H:i') ?></p>
<p class="p-content"><?= $post->getFormattedContent() ?></p>