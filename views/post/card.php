<?php
$categories= [];
foreach ((array)($post->getCategories()) as $category){
	$url= $router->url('category', ['id'=> $category->getID(), 'slug'=> $category->getSlug()]);
	$categories[]= "<a href='" .  $url . "' class='category-label'>" . $category->getName() ."</a>";
}
// dd($categories);

?>
		<div class="card">
			<div class="card-body">
			    <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
			    <p class="txt-muted"><?= $post->getCreatedAt()->format('d F Y H:i') ?></p>
				<div class="labels">
					<?php foreach ($categories as $key=> $category): ?>
						<?= $category ?>
					<?php endforeach ?>
				</div>
			    <p class="p-content"><?= $post->getExcerpt() ?></p>
			    <?php $arr= ['id'=> $post->getID(), 'slug'=> $post->getSlug()]; $href= $router->url('post', $arr); //dd($href) ?>
			    <p><a href="<?= $href ?>" class="btn url">Read more</a></p>
			</div>
		</div>