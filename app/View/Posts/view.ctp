<?php
/** @var array $post */
/** @var array $author */
/** @var boolean $canEdit */
/** @var boolean $canDelete */
?>
<div class="row justify-content-center">
    <div class="col-lg-8 p-3 border-left border-right border-bottom border-dark-light rounded-bottom bg-dark-light">
        <h1 class="border-bottom border-dark-light"><?= $post['title'] ?></h1>
        <div class="row align-items-center">
            <div class="col text-muted">
                Created on <?= $post['created'] ?> by
                <?= $this->Html->link($author['username'],
                    array('controller' => 'users', 'action' => 'view', $author['id'])) ?>.
            </div>
            <?php if($canEdit || $canDelete) { ?>
                <div class="col-auto mx-4 px-0">
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
    <div class="col-lg-8 p-4 text-dark">
        <?= $this->Markdown->text($post['body']) ?>
    </div>


</div>
