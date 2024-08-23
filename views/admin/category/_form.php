<form action="" method="POST">
    <?= $form->input('name', 'Title'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->textarea('content', 'Content'); ?>
    <?= $form->input('created_at', 'Creation date'); ?>

    <button class="btn prm"><?= $submit_text ?></button>
</form>