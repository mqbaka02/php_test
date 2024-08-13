<?php
use App\Connection;
use App\URL;
use App\Table\PostTable;

$title= 'The blog';
$pdo= Connection::getPDO();

// $currentpage= (int)($_GET['page']?? 1) ?: 1;
$currentpage= URL::getPositiveInt('page', 1);
if($currentpage< 0) {
	throw new Exception("Wrong page number");
}

$table= new PostTable($pdo);
[$posts, $pagination]= $table->findPaginated();

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
	<?= $pagination->previousLink($router->url('blog')) ?>
	<?= $pagination->nextLink($router->url('blog')) ?>
</div>