<?php
/** @var $user array */
/** @var $posts array */
/** @var $role array */
/** @var $isAccountOwner boolean */
/** @var $canDelete boolean */
/** @var $canEditPass boolean */
/** @var $canEditRole boolean */
/** @var $allRoles array If $canSetRole is true, this is a list of all available roles. */
$this->assign('title', h($user['username']).'\'s Profile');
?>

<?php
$this->start('accountActions');
if($canEditPass) { ?>
    <div class="row m-2 mt-4">
        <div class="col">
            <?= $this->Form->create('User', array(
                'url' => array('controller' => 'users', 'action' => 'editpass', $user['id']),
                'inputDefaults' => array(
                    'div' => array('class' => 'form-group ml-3'),
                    'wrapInput' => false,
                    'class' => 'form-control form-control-sm'
                )
            ))?>
            <div class="form-group text-nowrap"><h5><?= __('Change password') ?></h5></div>
            <?php
            echo $this->Form->input('old_password', array(
                'type' => 'password'
            ));
            echo $this->Form->input('new_password', array(
                'type' => 'password'
            ));
            echo $this->Form->submit(__('Apply'), array(
                'class' => 'btn btn-secondary my-2'
            ));
            echo $this->Form->end() ?>
        </div>
    </div>
<?php }
if($canEditRole) { ?>
    <div class="row m-2 mt-4">
        <div class="col">
            <?= $this->Form->create('User', array(
                'url' => array('controller' => 'users', 'action' => 'editrole'),
                'inputDefaults' => array(
                    'div' => array('class' => 'form-group ml-3'),
                    'wrapInput' => false,
                    'class' => 'form-control form-control-sm'
                )
            ))?>
            <h5 class="form-group text-nowrap"><?= __('Change user role') ?></h5>
            <?php
            echo $this->Form->input('id', array('type' => 'hidden', 'default' => $user['id']));
            $options = array_combine(
                array_column($allRoles, 'id'),
                array_map(
                    function($unsanitised) { return __(h($unsanitised)); },
                    array_column($allRoles, 'name')
                )
            );
            echo $this->Form->input('role_id', array(
                'label' => false,
                'options' => $options,
                'default' => $role['id']
            ), array('class' => 'custom-select')
            );
            echo $this->Form->submit(__('Apply'), array(
                'confirm' => __('Are you sure you want to change this user\'s role?'),
                'class' => 'btn btn-warning'
            ));
            ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php }
if($canDelete) { ?>
    <div class="row m-2 mt-5">
        <div class="col">
            <h5><?= __('Delete my account') ?></h5>
            <?= $this->Form->postLink(__('Delete Account'),
                array('controller' => 'users', 'action' => 'delete', $user['id']),
                array(
                    'confirm' => __('Are you sure you want to delete your account? This cannot be undone.'),
                    'class' => 'btn btn-danger m-2'
                )) ?>
        </div>
    </div>
<?php }
$this->end();
?>

<div class="row mt-3">
    <div class="col">
        <div class="row m-2 border border-dark rounded bg-light">
            <div class="col">
                <h1 class="mt-2 text-center font-weight-bold"><?= h($user['username']) ?></h1>
                <p class="text-muted text-center"> <?= __(h($role["name"])) ?></p>
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
        <?php } else if($canDelete || $canEditPass || $canEditRole) { ?>
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
