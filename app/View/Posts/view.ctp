<h1><?= $post['Post']['title'] ?></h1>
<?php if($post['Post']['created']) { ?>
    <p><small>Created on <?= $post['Post']['created'] ?></small></p>
<?php } ?>
<p>
    <?= $post['Post']['body'] ?>
</p>
