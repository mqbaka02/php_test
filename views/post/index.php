<?php

use App\Helpers\Text;
use App\Model\Post;

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
		<div class="card">
			<div class="card-body">
			    <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
			    <p class="txt-muted"><?= $post->getCreatedAt()->format('d F Y H:i') ?></p>
			    <p class="p-content"><?= $post->getExcerpt() ?></p>
			    <p><a href="<?php url('post?, 'id>=> " class="btn url">Read more</a></p>
			</div>
		</div>
	</div>
	<?php endforeach ?>
</div>