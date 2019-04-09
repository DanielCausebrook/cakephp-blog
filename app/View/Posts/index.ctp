<?php
/** @var $posts array */
?>
<h1>Blog Posts</h1>
<?php
if(AuthComponent::user('id')) {?>
    <?= $this->Html->link('New Post',
        array('controller' => 'posts', 'action' => 'add'),
        array('class' => 'btn btn-primary m-3')) ?>
<?php } ?>
<table class="table">
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Date Created</th>
    </tr>
    <?php foreach($posts as $post): ?>
    <tr>
        <td><?= $this->Html->link($post['Post']['title'],
                array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])) ?></td>
        <td><?= $this->Html->link($post['PostUser']['username'],
                array('controller' => 'users', 'action' => 'view', $post['PostUser']['id'])) ?></td>
        <td><?= $post['Post']['created'] ?></td>
    </tr>
    <?php
    endforeach;
    unset($post);
    ?>
</table>
