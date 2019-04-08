<?php
$this->extend('/Common/View');
/** @var $user array */
/** @var $posts array */
?>

<h1>User <?= $user['username'] ?></h1>

<h2>Posts</h2>
<table>
    <tr>
        <th>Title</th>
        <th>Date Created</th>
    </tr>

    <?php foreach ($posts as $post): ?>
    <tr>
        <td><?= $this->Html->link($post['title'],
                array('controller' => 'posts', 'action' => 'view', $post['id'])) ?></td>
        <td><?= $post['created'] ?></td>
    </tr>
    <?php
    endforeach;
    unset($post);
    ?>

</table>
