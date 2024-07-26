		<div class="card">
			<div class="card-body">
			    <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
			    <p class="txt-muted"><?= $post->getCreatedAt()->format('d F Y H:i') ?></p>
			    <p class="p-content"><?= $post->getExcerpt() ?></p>
			    <?php $arr= ['id'=> $post->getID(), 'slug'=> $post->getSlug()]; $href= $router->url('post', $arr); //dd($href) ?>
			    <p><a href="<?= $href ?>" class="btn url">Read more</a></p>
			</div>
		</div>