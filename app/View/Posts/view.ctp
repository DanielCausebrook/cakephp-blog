<h1><?= $post['Post']['title'] ?></h1>
<?php if($post['Post']['created']) { ?>
    <p><small>Created on <?= $post['Post']['created'] ?></small></p>
<?php } ?>
<p>
    <?= $post['Post']['body'] ?>
</p>

<?php if($canEdit) { ?>
    <div>
        <?= $this->Html->link(__('Edit'),
            array('controller' => 'posts', 'action' => 'edit', $post['Post']['id'])) ?>
        <?= $this->Form->postLink('Delete',
            array('controller' => 'posts', 'action' => 'delete', $post['Post']['id']),
            array('confirm' => 'Are you sure?')) ?>
    </div>
<?php } ?>
