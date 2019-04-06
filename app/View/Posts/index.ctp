<h1>Blog Posts</h1>
<?php
if(isset($loggedIn)) {?>
    <p>Signed in.
    <?= $this->Html->link('Logout',
        array('controller' => 'users', 'action' => 'logout')) ?>
    <?= $this->Html->link('New Post',
        array('controller' => 'posts', 'action' => 'add')) ?>
    </p>
<?php } else { ?>
    <?= $this->Html->link('Login',
        array('controller' => 'users', 'action' => 'login')) ?>

<?php } ?>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Created</th>
    </tr>
    <?php foreach($posts as $post): ?>
    <tr>
        <td><?= $post['Post']['id'] ?></td>
        <td><?= $this->Html->link($post['Post']['title'],
            array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])) ?></td>
        <td><?= $post['Post']['created'] ?></td>
    </tr>
    <?php
    endforeach;
    unset($post);
    ?>
</table>
