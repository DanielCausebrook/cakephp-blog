<?php
$this->extend('/Common/View');
?>
<h1>Edit post</h1>
<?= $this->Form->create('Post') ?>
<?= $this->Form->input('title') ?>
<?= $this->Form->input('body', array('rows' => '3')) ?>
<?= $this->Form->input('id', array('type' => 'hidden')) ?>
<?= $this->Form->end('Save Post') ?>
