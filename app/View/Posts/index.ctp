<?php
/** @var $posts array */
/** @var $canAdd boolean */
?>
<h1 class="mt-3 p-2">Blog Posts</h1>
<?php
if($canAdd) {?>
    <?= $this->Html->link('New Post',
        array('controller' => 'posts', 'action' => 'add'),
        array('class' => 'btn btn-primary m-3')) ?>
<?php } ?>
<table class="table border-bottom">
    <tr class="border-left border-right">
        <th>Title</th>
        <th class="bg-light">Author</th>
        <th class="bg-light">Date Created</th>
    </tr>
    <?php foreach($posts as $post): ?>
    <tr class="border-left border-right">
        <td class="font-weight-bold"><?= $this->Html->link($post['Post']['title'],
                array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])) ?></td>
        <td class="bg-light"><?= $this->Html->link($post['PostUser']['username'],
                array('controller' => 'users', 'action' => 'view', $post['PostUser']['id'])) ?></td>
        <td class="bg-light"><?= $post['Post']['created'] ?></td>
    </tr>
    <?php
    endforeach;
    unset($post);
    ?>
</table>
