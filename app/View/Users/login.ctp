<div class="users form">
    <?= $this->Flash->render('auth') ?>
    <h1><?= __("Please enter your credentials:") ?></h1>
    <?= $this->Form->create('User') ?>
    <?= $this->Form->input('username') ?>
    <?= $this->Form->input('password') ?>
    <?= $this->Form->end(__('Login')) ?>
</div>
