<h1><?= __('New post') ?></h1>
<?= $this->Form->create('Post', array(
    'inputDefaults' => array(
        'div' => 'form-group',
        'wrapInput' => false,
        'class' => 'form-control'
    ))) ?>
<?= $this->Form->input('title') ?>
<?= $this->Form->input('body', array('rows' => '3')) ?>
<?= $this->Form->submit(__('Save Post'), array(
    'class' => 'btn btn-primary'
)) ?>
<?= $this->Form->end() ?>

