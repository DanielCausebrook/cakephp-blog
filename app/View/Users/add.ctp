<h1><?= __('Register') ?></h1>
<?= $this->Form->create('User', array(
    'inputDefaults' => array(
        'div' => 'form-group',
        'wrapInput' => false,
        'class' => 'form-control'
    ))) ?>
<?= $this->Form->input('username') ?>
<?= $this->Form->input('password') ?>
<?= $this->Form->submit(__('Submit'), array(
    'class' => 'btn btn-primary'
)) ?>
<?= $this->Form->end() ?>
