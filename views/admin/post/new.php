<?php
use App\Connection;
use App\Table\PostTable;
use App\ObjectHelper;
use App\Validators\PostValidator;
use App\HTML\Form;
use App\Model\Post;

use App\Auth;
Auth::check();

$errors= [];
$post= new Post();
$post->setCreatedAt(date('Y-m-d H:i:s'));

if(!empty($_POST)){
    $pdo= Connection::getPDO();
    $postTable= new PostTable($pdo);

    $validator= new PostValidator($_POST, $postTable, $post->getID());

    if($validator->validate()){//hydrate only if validation passed
        ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);

        $postTable->createPost($post);

        header('Location: ' . $router->url('admin_post', ['id'=> $post->getID()]) . '?creation_success=1');
        exit();
    } else {
        // dd($validator->errors());
        $errors= $validator->errors();
    }
}

$title= "Create a post";

$form= new Form($post, $errors);
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

<h1>Create new post</h1>
<?php $submit_text= "Create" ?>
<?php require('_form.php') ?>