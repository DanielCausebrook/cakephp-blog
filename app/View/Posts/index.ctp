<?php
/** @var $posts array */
/** @var $canAdd boolean */
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="row mt-3 mb-5 align-items-center border-bottom border-dark-light">
            <h1 class="col p-2">Blog Posts</h1>
            <div class="col-auto" >
                <?php if($canAdd) {
                    echo $this->Html->link('New Post',
                        array('controller' => 'posts', 'action' => 'add'),
                        array('class' => 'btn btn-primary m-2'));
                } ?>
            </div>
        </div>
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
    </div>
</div>
