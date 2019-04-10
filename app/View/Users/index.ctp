<?php
/** @var $users array */
?>
<h1 class="mt-3 p-2">User list</h1>

<table class="table border-bottom">
    <tr class="border-left border-right bg-light">
        <th>Username</th>
        <th>Posts</th>
        <th>Role</th>
    </tr>
    <?php foreach($users as $user): ?>
    <tr class="border-left border-right">
        <td><?= $this->Html->link($user['User']['username'],
                array('controller' => 'users', 'action' => 'view', $user['User']['id'])) ?></td>
        <td><?= h($user['User']['post_count']) ?></td>
        <td><?= h($user['UserRole']['name']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
