<?php
use App\Connection;
use App\Table\CategoryTable;
use App\ObjectHelper;
use App\Validators\CategoryValidator;
use App\HTML\Form;
use App\Model\Category;

use App\Auth;
Auth::check();

$errors= [];
$item= new Category();

if(!empty($_POST)){
    $pdo= Connection::getPDO();
    $categoryTable= new CategoryTable($pdo);

    $validator= new CategoryValidator($_POST, $categoryTable, $item->getID());

    if($validator->validate()){//hydrate only if validation passed
        ObjectHelper::hydrate($item, $_POST, ['name', 'slug']);

        $categoryTable->create([
            'name'=> $item->getName(),
            'slug'=> $item->getSlug()
        ]);

        header('Location: ' . $router->url('admin_categories') . '?creation_success=1');
        exit();
    } else {
        // dd($validator->errors());
        $errors= $validator->errors();
    }
}

$title= "Create a post";

$form= new Form($item, $errors);
?>

<?php if(!empty($errors)): ?>
    <div class="alert failure">
        Please correct the mistakes before proceding.
        <ul>
            <?php foreach($errors as $k=> $error): ?>
                <?php foreach ($error as $err) : ?>
                    <li><?= 'On ' . $k . ': ' . $err ?></li>
                <?php endforeach ?>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<h1>Create new category</h1>
<?php $submit_text= "Create" ?>
<?php require('_form.php') ?>