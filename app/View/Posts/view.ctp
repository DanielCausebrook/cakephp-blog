<?php
/** @var array $post */
/** @var array $author */
/** @var boolean $canEdit */
/** @var boolean $canDelete */
?>
<div class="p-3 border-left border-right border-bottom rounded-bottom bg-light">
    <h1 class="border-bottom"><?= $post['title'] ?></h1>
    <div class="row align-items-center">
        <div class="col-auto text-muted">
            Created on <?= $post['created'] ?> by
            <?= $this->Html->link($author['username'],
                array('controller' => 'users', 'action' => 'view', $author['id'])) ?>.
        </div>
        <?php if($canEdit || $canDelete) { ?>
        <div class="col-auto px-0">
            <?php if($canEdit)
                echo $this->Html->link(__('Edit'),
                    array('controller' => 'posts', 'action' => 'edit', $post['id']),
                    array('class' => 'btn p-0 px-1 btn-secondary btn-sm')); ?>
            <?php if($canDelete)
                echo $this->Form->postLink('Delete',
                    array('controller' => 'posts', 'action' => 'delete', $post['id']),
                    array(
                        'confirm' => 'Are you sure?',
                        'class' => 'btn p-0 px-1 btn-danger btn-sm'
                    )); ?>
        </div>
        <?php } ?>
    </div>
</div>
<div class="m-3 mt-4 text-dark">
    <?= $this->Markdown->text($post['body']) ?>
</div>

