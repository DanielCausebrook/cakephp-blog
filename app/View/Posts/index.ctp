<h1>Blog Posts</h1>
<?= $this->Html->link('New Post',
    array('controller' => 'posts', 'action' => 'add')) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Actions</th>
        <th>Created</th>
    </tr>
    <?php foreach($posts as $post): ?>
    <tr>
        <td><?= $post['Post']['id'] ?></td>
        <td><?= $this->Html->link($post['Post']['title'],
            array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])) ?></td>
        <td>
            <?= $this->Html->link('Edit',
                array('controller' => 'posts', 'action' => 'edit', $post['Post']['id']))?>
            &nbsp;
            <?= $this->Form->postLink('Delete',
                array('controller' => 'posts', 'action' => 'delete', $post['Post']['id']),
                array('confirm' => 'Are you sure?')) ?>
        </td>
        <td><?= $post['Post']['created'] ?></td>
    </tr>
    <?php
    endforeach;
    unset($post);
    ?>
</table>
