<?php
use App\Model\User;
use App\HTML\Form;
use App\Connection;
use App\Table\UserTable;
use App\Table\Exception\NotFoundException;

$user= new User();
$errors=[];

if(!empty($_POST)){
    if(empty($_POST['password'])){
        // dump($_POST);
        $errors['password']= ['Password is empty.'];
    }
    if(empty($_POST['username'])){
        // dump($_POST);
        $errors['username']= ['Username is empty.'];
    }
    $user->setUsername($_POST['username']);
    $user->setPassword($_POST['password']);
    $table= new UserTable(Connection::getPDO());
    try{
        $u= $table->findByUsername($_POST['username']);
        // $u->getPassword();
        if(password_verify($_POST['password'], $u->getPassword())=== false){
            $errors['password']= ['Login is incorrect'];
        } else {
            session_start();
            // dd($_SESSION);
            $_SESSION['auth']= $u->getID();
            header('Location: ' . $router->url('admin_posts'));
            exit();
        }

    } catch (NotFoundException $e) {
        $errors['username']= ['This username is not recognized.'];
    }
}

$form= new Form($user, $errors);

?>

<?php if(!empty($errors)): ?>
    <div class="alert failure">
        Please correct the mistakes before proceeding.
        <ul>
            <?php foreach($errors as $k=> $error): ?>
                <?php foreach ($error as $err) : ?>
                    <li><?= 'On ' . $k . ': ' . $err ?></li>
                <?php endforeach ?>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<?php if(isset($_GET['forbidden'])): ?>
    <div class="alert failure">
        Please log in before proceeding.
    </div>
<?php endif ?>

<h1>Log in</h1>

<form method="POST" action="<?= $router->url('login') ?>">
    <?= $form->input('username', 'User Name'); ?>
    <?= $form->input('password', 'Password'); ?>
    <button class="btn prm">Log in</button>
</form>