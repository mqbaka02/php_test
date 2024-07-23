<?php
use App\Helpers\Text;
use App\Model\Post;
require '../vendor/autoload.php';

$title= 'The blog';

$pdo= new PDO('mysql:dbname=tutoblog;host=localhost', 'root', 'root',[
	PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION
]);
$query= $pdo->query("SELECT* FROM post ORDER BY created_at DESC LIMIT 12");
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