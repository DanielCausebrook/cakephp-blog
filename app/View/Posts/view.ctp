<?php
$this->extend('/Common/view');
/** @var array $post */
/** @var array $author */
/** @var boolean $canEdit */
/** @var boolean $canDelete */
?>
<h1><?= $post['title'] ?></h1>
<?php if($post['created']) { ?>
    <p>
        Created on <?= $post['created'] ?> by
        <?= $this->Html->link($author['username'],
            array('controller' => 'users', 'action' => 'view', $author['id'])) ?>
        .
    </p>
<?php } ?>
<p>
    <?= $post['body'] ?>
</p>

<?php if($canEdit || $canDelete) { ?>
    <div>
        <?php if($canEdit)
            echo $this->Html->link(__('Edit'),
                array('controller' => 'posts', 'action' => 'edit', $post['id'])); ?>
        <?php if($canDelete)
            echo $this->Form->postLink('Delete',
                array('controller' => 'posts', 'action' => 'delete', $post['id']),
                array('confirm' => 'Are you sure?')); ?>
    </div>
<?php } ?>
