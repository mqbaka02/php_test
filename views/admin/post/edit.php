<?php
use App\Connection;
use App\Table\PostTable;
use App\Validator;
// use Valitron\Validator;

$pdo= Connection::getPDO();
$postTable= new PostTable($pdo);
$post= $postTable->find($params['id']);
$success= false;

$errors= [];

if(!empty($_POST)){
    $validator= new Validator($_POST);
    $validator->rule('required', 'name');
    $validator->rule('lengthBetween', 'name',3, 200);

    // if(empty($_POST['name'])){
    //     $errors['name'][]= "Title cannot be empty.";
    // }
    // if(mb_strlen($_POST['name'])<= 3){
    //     $errors['name'][]= "Title is too short. Please add more than 3 letters.";
    // }

    // if(empty($errors)){
    if($validator->validate()){
        $post
            ->setName($_POST['name']);
            // ->setContent($_POST['content']);
        $postTable->update($post);
        $success= true;
    } else {
        // dd($validator->errors());
        $errors= $validator->errors();
    }
}

$title= $post->getName() . ": Edit post";
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
            <?php foreach($errors['name'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<h1>Edit post<br/>#<?= $params['id'] ?> <?= $post->getName() ?></h1>

<form action="" method="post">
<div class="form-grp">
    <label for="name">Title</label>
    <input type="text" class="form-ctrl" name="name" value="<?= (!empty($_POST['name']))? $_POST['name'] : $post->getName() ?>" >
    <?php if(isset($errors['name'])): ?>
        <div class="invalid-feedback">
            Some mistakes
        </div>
    <?php endif ?>
</div>

<button class="btn prm">Save</button>
</form>