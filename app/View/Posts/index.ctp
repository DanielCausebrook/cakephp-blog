<?php
/** @var $posts array */
/** @var $canAdd boolean */
$this->assign('title', 'Posts');
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="row mt-3 mb-5 align-items-center border-bottom border-dark-light">
            <h1 class="col p-2"><?= __('Blog Posts') ?></h1>
            <div class="col-auto" >
                <?php if($canAdd) {
                    echo $this->Html->link(__('New Post'),
                        array('controller' => 'posts', 'action' => 'add'),
                        array('class' => 'btn btn-primary m-2'));
                } ?>
            </div>
        </div>
        <table class="table border-bottom">
            <tr class="border-left border-right">
                <th><?= __('Title') ?></th>
                <th class="bg-light"><?= __('Author') ?></th>
                <th class="bg-light"><?= __('Date Created') ?></th>
            </tr>
            <?php foreach($posts as $post): ?>
                <tr class="border-left border-right">
                    <td class="font-weight-bold"><?= $this->Html->link(h($post['Post']['title']),
                            array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])) ?></td>
                    <td class="bg-light"><?= $this->Html->link(h($post['PostUser']['username']),
                            array('controller' => 'users', 'action' => 'view', $post['PostUser']['id'])) ?></td>
                    <td class="bg-light"><?= $post['Post']['created'] ?></td>
                </tr>
            <?php
            endforeach;
            unset($post);
            ?>
        </table>
    </div>
</div>
