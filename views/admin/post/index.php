<?php
use App\Connection;
use App\Table\PostTable;
use App\Auth;

Auth::check();

$title= "Administration";

$pdo= Connection::getPDO();
[$posts, $pagination]= (new PostTable($pdo))->findPaginated();
?>

<?php if(isset($_GET['delete'])): ?>
    <div class="alert success">
        The entry has been removed successfully.
    </div>
<?php endif ?>

<table class="striped pad1">
    <thead>
        <th>ID</th>
        <th>Title</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php foreach($posts as $post): ?>
            <tr>
                <td>
                    <?= $post->getID() ?>
                </td>
                <td>
                    <!-- <a href=<?php //echo "admin/edit/" . $post->getID() ?>> -->
                    <a href="<?= $router->url('admin_post', ['id'=> $post->getID()]) ?>">
                        <?= htmlentities($post->getName()) ?>
                    </a>
                </td>
                <td>
                    <div>
                        <a href="<?= $router->url('admin_post', ['id'=> $post->getID()]) ?>" class="btn prm">
                            Edit
                        </a>
                        <form action="<?= $router->url('admin_post_delete', ['id'=> $post->getID()]) ?>" method="post" onsubmit="return confirm('Are you sure you want to delete that post?')" style="display:inline">
                            <button class="btn dng" type="submit">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<div class="g-flex bottom">
	<?= $pagination->previousLink($router->url('admin_posts')) ?>
	<?= $pagination->nextLink($router->url('admin_posts')) ?>
</div>