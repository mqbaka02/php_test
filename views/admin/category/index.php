<?php
use App\Connection;
use App\Table\CategoryTable;

use App\Auth;
Auth::check();

$title= "Administration";

$pdo= Connection::getPDO();
$items= (new CategoryTable($pdo))->all();
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
        <th>Slug</th>
        <th><a href="<?= $router->url('admin_category_new') ?>" class="btn prm">Create new</a></th>
    </thead>
    <tbody>
        <?php foreach($items as $item): ?>
            <tr>
                <td>
                    <?= $item->getID() ?>
                </td>
                <td>
                    <a href="<?= $router->url('admin_category', ['id'=> $item->getID()]) ?>">
                        <?= htmlentities($item->getName()) ?>
                    </a>
                </td>
                <td><?= $item->getSlug() ?></td>
                <td>
                    <div>
                        <a href="<?= $router->url('admin_category', ['id'=> $item->getID()]) ?>" class="btn prm">
                            Edit
                        </a>
                        <form action="<?= $router->url('admin_category_delete', ['id'=> $item->getID()]) ?>" method="post" onsubmit="return confirm('Are you sure you want to delete that category?')" style="display:inline">
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