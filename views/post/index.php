<?php
use App\Helpers\Text;
use App\Model\Post;
use App\Connection;
use App\URL;
use App\PaginatedQuery;
require '../vendor/autoload.php';

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