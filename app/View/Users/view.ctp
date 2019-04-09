<?php
/** @var $user array */
/** @var $posts array */
/** @var $role array */
?>
<div class="row">
    <div class="col">
        <div class="row m-2 border border-dark rounded bg-light">
            <div class="col">
                <h1 class="mt-2 text-center font-weight-bold"><?= h($user['username']) ?></h1>
                <p class="text-muted text-center"> <?= h($role["name"]) ?></p>
                <p><?= __('Posts: %s', count($posts)) ?> </p>
                <p><?= __('Member since %s', $user['created']) ?></p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row m-2 p-2 border rounded">
            <div class="col">
                <h2 class="m-2 mb-4">Posts</h2>
                <?php if(count($posts) === 0) { ?>
                    <p class="text-muted text-center"><?= __('This user has not yet created any posts.') ?></p>
                <?php } else { ?>
                    <table class="table">
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
                <?php } ?>
            </div>
        </div>
    </div>
</div>
