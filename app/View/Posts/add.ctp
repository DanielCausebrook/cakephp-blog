<?php
$this->assign('title', 'New Post');
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="row mt-3 mb-4 align-items-center border-bottom border-dark-light">
            <h1 class="col p-2"><?= __('New post') ?></h1>
        </div>
        <?= $this->Form->create('Post', array(
            'inputDefaults' => array(
                'label' => array(
                    'class' => 'font-weight-bold'
                ),
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
    </div>
</div>
