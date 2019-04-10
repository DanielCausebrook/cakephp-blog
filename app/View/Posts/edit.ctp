<h1 class="mt-4 p-2">Edit post</h1>
<?= $this->Form->create('Post', array(
    'inputDefaults' => array(
        'div' => 'form-group',
        'wrapInput' => false,
        'class' => 'form-control'
    ))) ?>
<?= $this->Form->input('title') ?>
<?= $this->Form->input('body', array('rows' => '3')) ?>
<?= $this->Form->input('id', array('type' => 'hidden')) ?>
<div class="row align-items-center">
    <div class="col-auto">
        <?= $this->Form->submit(__('Save Post'), array(
            'class' => 'btn btn-primary'
        )) ?>
    </div>
    <div class="col-auto">
        <?= $this->Html->link(__('Cancel'),
            array('controller' => 'posts', 'action' => 'view', $this->request['pass'][0])) ?>
    </div>
</div>
<?= $this->Form->end() ?>
