<?php
use App\Connection;
use App\Table\PostTable;
use App\Validator;
use App\HTML\Form;
// use Valitron\Validator;

$pdo= Connection::getPDO();
$postTable= new PostTable($pdo);
$post= $postTable->find($params['id']);
$success= false;

$errors= [];

if(!empty($_POST)){
    $validator= new Validator($_POST);
    $validator->rule('required', ['name', 'slug']);
    $validator->rule('lengthBetween', ['name', 'slug'],3, 200);
    $validator->rule('regex', 'name', '/^[a-zA-Z\p{P}\s]+$/u');

    // if(empty($_POST['name'])){
    //     $errors['name'][]= "Title cannot be empty.";
    // }
    // if(mb_strlen($_POST['name'])<= 3){
    //     $errors['name'][]= "Title is too short. Please add more than 3 letters.";
    // }

    // if(empty($errors)){
    if($validator->validate()){
        $post
            ->setName($_POST['name'])
            ->setContent($_POST['content']);
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
                    <li><?= 'The parameter ' . $k . ' ' . $err ?></li>
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

    <button class="btn prm">Save</button>
</form>