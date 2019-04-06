<h1>Create a new user account</h1>
<?= $this->Form->create('User') ?>
<?= $this->Form->input('username') ?>
<?= $this->Form->input('password') ?>
<?= $this->Form->end(__('Submit')) ?>
