<?php
use App\Connection;
use App\Table\PostTable;
use App\ObjectHelper;
use App\Validators\PostValidator;
use App\HTML\Form;

$pdo= Connection::getPDO();
$postTable= new PostTable($pdo);
$post= $postTable->find($params['id']);
$success= false;

$errors= [];

if(!empty($_POST)){
    $validator= new PostValidator($_POST, $postTable, $post->getID());

    if($validator->validate()){//hydrate only if validation passed
        
        ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);

        $postTable->update($post);
        $success= true;
    } else {
        // dd($validator->errors());
        $errors= $validator->errors();
    }
}

$title= $post->getName() . ": Edit post";

$form= new Form($post, $errors);
?>

<?php if($success=== true): ?>
    <div class="alert success">
        Post edited successfully.
    </div>
<?php endif ?>

<?php if(isset($_GET['creation_success'])): ?>
    <div class="alert success">
        Post created successfully.
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

<h1>Edit post<br/>#<?= $params['id'] ?> <?= $post->getName() ?></h1>

<?php $submit_text= "Save" ?>
<?php require('_form.php') ?>