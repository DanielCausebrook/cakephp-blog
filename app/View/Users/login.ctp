<?php
$this->assign('title', 'Login');
?>
<div class="row mt-5 justify-content-center">
    <div class="col-md-5 p-4 border border-dark-light rounded bg-dark-light">
        <h1 class="mb-3"><?= __('Welcome back!') ?></h1>
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
        <div class="mt-3">
            <?= __('Don\'t have an account yet?') ?>
            <?= $this->Html->link(__('Register here!'),
                array('controller' => 'users', 'action' => 'add')
            ) ?>
        </div>
    </div>
</div>
