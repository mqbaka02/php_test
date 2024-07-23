		<div class="card">
			<div class="card-body">
			    <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
			    <p class="txt-muted"><?= $post->getCreatedAt()->format('d F Y H:i') ?></p>
			    <p class="p-content"><?= $post->getExcerpt() ?></p>
			    <p><a href="<?= $router->url('post', ['id'=> $post->getID(), 'slug'=> $post->getSlug()]) ?>" class="btn url">Read more</a></p>
			</div>
		</div>