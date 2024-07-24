<?php
use App\Helpers\Text;
use App\Model\Post;
require '../vendor/autoload.php';

$title= 'The blog';
$pdo= new PDO('mysql:dbname=tutoblog;host=localhost', 'root', 'root',[
	PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION
]);

$page= $_GET['page']?? 1;
if (!filter_var($page, FILTER_VALIDATE_INT)) {
	throw new Exception("Page number invalid.");
}

if($page=== '1'){
	header('Location: ' . $router->url('blog'));
	http_response_code(301);
	exit();
}

// $currentpage= (int)($_GET['page']?? 1) ?: 1;
$currentpage= (int)$page;
if($currentpage< 0) {
	throw new Exception("Wrong page number");
}
$count= (int)$pdo->query("SELECT COUNT(id) FROM post")->fetch(PDO::FETCH_NUM)[0];
$per_page= 12;
$pages= ceil($count/12);
if($currentpage> $pages) {
	throw new Exception("Wrong page number");
}

$offset= $per_page * ($currentpage - 1);
$query= $pdo->query("SELECT* FROM post ORDER BY created_at DESC LIMIT " . $per_page . " OFFSET " . $offset);
$posts= $query->fetchAll(PDO::FETCH_CLASS, Post::class);
?>

<h1>Blog</h1>

<div class="row">
	<?php foreach ($posts as $post): ?>
	<div class="col-md-3">
		<?php require 'card.php' ?>
	</div>
	<?php endforeach ?>
</div>

<div class="g-flex">
	<?php  if($currentpage > 1) : ?>
	<a href="<?= $router->url('blog') ?>?page=<?= $currentpage - 1?>" class= 'btn prm' ?>&laquo; Previous page</a>
	<?php endif ?>
	<?php  if($currentpage < $pages) : ?>
	<a href="<?= $router->url('blog') ?>?page=<?= $currentpage + 1?>" class= 'btn prm' id="nxt-pg"?>Next page &raquo;</a>
	<?php endif ?>

</div>