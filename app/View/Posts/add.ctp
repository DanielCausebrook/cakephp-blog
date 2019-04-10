<h1 class="mt-3 p-2"><?= __('New post') ?></h1>
<?= $this->Form->create('Post', array(
    'inputDefaults' => array(
        'div' => 'form-group',
        'wrapInput' => false,
        'class' => 'form-control'
    ))) ?>
<?= $this->Form->input('title') ?>
<?= $this->Form->input('body', array('rows' => '3')) ?>
<div class="row align-items-center">
    <div class="col-auto">
        <?= $this->Form->submit(__('Save Post'), array(
            'class' => 'btn btn-primary'
        )) ?>
    </div>
    <div class="col-auto">
        <?= $this->Html->link(__('Cancel'),
            array('controller' => 'posts', 'action' => 'index')) ?>
    </div>
</div>
<?= $this->Form->end() ?>

