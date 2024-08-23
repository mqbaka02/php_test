<?php
use App\Connection;
use App\Table\PostTable;
use App\ObjectHelper;
use App\Validators\CategoryValidator;
use App\HTML\Form;

use App\Auth;
Auth::check();

$pdo= Connection::getPDO();
$table= new CategoryTable($pdo);
$item= $table->find($params['id']);
$success= false;
$fileds_list= ['name', 'slug'];

$errors= [];

if(!empty($_POST)){
    $validator= new CategoryValidator($_POST, $table, $item->getID());

    if($validator->validate()){//hydrate only if validation passed
        
        ObjectHelper::hydrate($item, $_POST, $fileds_list);

        $table->update([
            'name'=> $item->getName(),
            'slug'=> $item->getSlug()
        ], $item->getID());
        $success= true;
    } else {
        // dd($validator->errors());
        $errors= $validator->errors();
    }
}

$title= $item->getName() . ": Edit post";

$form= new Form($item, $errors);
?>

<?php if($success=== true): ?>
    <div class="alert success">
        Category edited successfully.
    </div>
<?php endif ?>

<?php if(isset($_GET['creation_success'])): ?>
    <div class="alert success">
        Category created successfully.
    </div>
<?php endif ?>

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

<h1>Edit category<br/>#<?= $params['id'] ?> <?= $item->getName() ?></h1>

<?php $submit_text= "Save" ?>
<?php require('_form.php') ?>