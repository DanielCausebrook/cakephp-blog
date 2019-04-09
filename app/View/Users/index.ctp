<?php
/** @var $users array */
?>
<h1>User list</h1>

<table class="table">
    <tr>
        <th>Username</th>
        <th>Role</th>
    </tr>
    <?php foreach($users as $user): ?>
    <tr>
        <td><?= $this->Html->link($user['User']['username'],
                array('controller' => 'users', 'action' => 'view', $user['User']['id'])) ?></td>
        <td><?= $user['UserRole']['name'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
