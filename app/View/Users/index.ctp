<?php
/** @var $users array */
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="row mt-3 mb-5 align-items-center border-bottom border-dark-light">
            <h1 class="col p-2">All Users</h1>
        </div>
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
    </div>
</div>
