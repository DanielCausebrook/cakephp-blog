<?php
/** @var $user array */
/** @var $posts array */
/** @var $role array */
/** @var $isAccountOwner boolean */
/** @var $canDelete boolean */
/** @var $canEditRole boolean */
/** @var $allRoles array If $canSetRole is true, this is a list of all available roles. */
?>

<?php
$this->start('accountActions');
if($canEditRole) { ?>
    <div class="row m-2 mt-4 px-2 pb-2 pt-0 border border-dark-light rounded">
        <?= $this->Form->create('User', array(
            'url' => array('controller' => 'users', 'action' => 'editrole'),
            'inputDefaults' => array(
                'div' => array('class' => 'col'),
                'wrapInput' => false,
                'class' => 'form-control form-control-sm'
            )
        ))?>
        <div class="row m-1 text-nowrap font-weight-bold"><?= __('Change user role') ?></div>
        <div class="form-row">
            <?= $this->Form->input('id', array('type' => 'hidden', 'default' => $user['id'])) ?>
            <?php
            $options = array_combine(array_column($allRoles, 'id'), array_column($allRoles, 'name'));
            echo $this->Form->input('role_id', array(
                'label' => false,
                'options' => $options,
                'default' => $role['id']
            ), array('class' => 'custom-select')
            );
            echo $this->Form->submit(__('Apply'), array(
                'class' => 'btn btn-sm btn-warning'
            ));
            ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
<?php }
if($isAccountOwner) { ?>
    <div class="row m-2 mt-4 px-2 pb-2 pt-0 border border-dark-light rounded">
        <?= $this->Form->create('User', array(
            'url' => array('controller' => 'users', 'action' => 'editpass'),
            'inputDefaults' => array(
                'div' => array('class' => 'col'),
                'wrapInput' => false,
                'class' => 'form-control form-control-sm'
            )
        ))?>
        <div class="row m-1 text-nowrap font-weight-bold"><?= __('Change password') ?></div>

        <?= $this->Form->end() ?>
    </div>
<?php }
if($canDelete) { ?>
    <div class="row m-2 mt-4">
        <?= $this->Html->link('Delete Account',
            array('controller' => 'users', 'action' => 'delete', $user['id']),
            array('class' => 'btn btn-danger')) ?>
    </div>
<?php }
$this->end();
?>

<div class="row mt-3">
    <div class="col">
        <div class="row m-2 border border-dark rounded bg-light">
            <div class="col">
                <h1 class="mt-2 text-center font-weight-bold"><?= h($user['username']) ?></h1>
                <p class="text-muted text-center"> <?= h($role["name"]) ?></p>
                <p><?= __('Posts: %s', $user['post_count']) ?> </p>
                <p><?= __('Member since %s', $user['created']) ?></p>
            </div>
        </div>
        <?php if($isAccountOwner) { ?>
            <div class="row m-2 mt-4 border border-dark-light rounded bg-dark-light">
                <div class="col m-4">
                    <h2 class="row mb-4 border-bottom border-dark rounded-top"><?= __('My Account Settings') ?></h2>
                    <?= $this->fetch('accountActions') ?>
                </div>
            </div>
        <?php } else if($canDelete || $canEditRole) { ?>
            <div class="row m-2 mt-4 border border-danger-light rounded bg-danger-light">
                <div class="col m-4">
                    <h2 class="row mb-4 border-bottom border-dark rounded-top"><?= __('Configure Account') ?></h2>
                    <?= $this->fetch('accountActions') ?>
                </div>
            </div>

        <?php } ?>


    </div>
    <div class="col">
        <div class="row m-2 border rounded">
            <div class="col m-4">
                <h2 class="mb-4"><?= __('Posts') ?></h2>
                <?php if(count($posts) === 0) { ?>
                    <p class="text-muted text-center"><?= __('This user has not yet created any posts.') ?></p>
                <?php } else { ?>
                    <table class="table">
                        <tr>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Date Created') ?></th>
                        </tr>

                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td><?= $this->Html->link($post['title'],
                                        array('controller' => 'posts', 'action' => 'view', $post['id'])) ?></td>
                                <td><?= $post['created'] ?></td>
                            </tr>
                        <?php
                        endforeach;
                        unset($post);
                        ?>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
