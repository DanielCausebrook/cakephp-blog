<?php
/** @var array $post */
/** @var array $author */
/** @var boolean $canEdit */
/** @var boolean $canDelete */
?>
<div class="p-3 border rounded">
    <h1><?= $post['title'] ?></h1>
    <div class="row align-items-center">
        <div class="col-auto text-muted">
            Created on <?= $post['created'] ?> by
            <?= $this->Html->link($author['username'],
                array('controller' => 'users', 'action' => 'view', $author['id'])) ?>.
            <?php if($canEdit || $canDelete) { ?>
        </div>
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
    </div>
<?php } ?>
    </p>
    <p>
        <?= $post['body'] ?>
    </p>

</div>
