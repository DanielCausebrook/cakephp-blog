<div class="row mt-5 justify-content-center">
    <div class="col-md-5 p-4 border border-dark-light rounded bg-dark-light">
        <h1 class="mb-3"><?= __('Create an account') ?></h1>
        <?= $this->Form->create('User', array(
            'inputDefaults' => array(
                'div' => 'form-group',
                'wrapInput' => false,
                'class' => 'form-control'
            ))) ?>
        <?= $this->Form->input('username') ?>
        <?= $this->Form->input('password') ?>
        <?= $this->Form->submit(__('Register'), array(
            'class' => 'btn btn-primary'
        )) ?>
        <?= $this->Form->end() ?>
        <div class="mt-3">
            <?= __('Already have an account?') ?>
            <?= $this->Html->link(__('Login here.'),
                array('controller' => 'users', 'action' => 'login')
            ) ?>
        </div>
    </div>
</div>
