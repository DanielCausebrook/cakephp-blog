<div class="users form">
    <h1><?= __('Login') ?></h1>
    <?= $this->Flash->render('auth') ?>
    <h2><?= __('Please enter your credentials:') ?></h2>
    <?= $this->Form->create('User', array(
        'inputDefaults' => array(
            'div' => 'form-group',
            'wrapInput' => false,
            'class' => 'form-control'
        ))) ?>
    <?= $this->Form->input('username') ?>
    <?= $this->Form->input('password') ?>
    <?= $this->Form->submit(__('Login'), array(
        'class' => 'btn btn-primary'
    )) ?>
    <?= $this->Form->end() ?>
</div>
