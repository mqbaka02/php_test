<?php
use App\Model\User;
use App\HTML\Form;

$user= new User();
$form= new Form($user, []);
$errors=[];

if(!empty($_POST)){
    if(!empty($_POST['username'])||empty($_POST['password'])){
        $errors['password']= ['Login is incorrect.'];
    }
}

?>

<h1>Log in</h1>

<form action="POST" action="">
    <?= $form->input('username', 'User Name'); ?>
    <?= $form->input('password', 'Password'); ?>
    <button class="btn prm">Log in</button>
</form>