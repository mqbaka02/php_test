<?php
use App\Connection;
use App\Table\PostTable;
use App\Validator;
use App\Validators\PostValidator;
use App\HTML\Form;

$pdo= Connection::getPDO();
$postTable= new PostTable($pdo);
$post= $postTable->find($params['id']);
$success= false;

$errors= [];

if(!empty($_POST)){
    $validator= new PostValidator($_POST, $postTable, $post->getID());

    if($validator->validate()){
        $post
            ->setName($_POST['name'])
            ->setContent($_POST['content'])
            ->setSlug($_POST['slug'])
            ->setCreatedAt($_POST['created_at']);
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

<form action="" method="POST">
    <?= $form->input('name', 'Title'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->textarea('content', 'Content'); ?>
    <?= $form->input('created_at', 'Creation date'); ?>

    <button class="btn prm">Save</button>
</form>